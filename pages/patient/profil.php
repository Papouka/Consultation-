<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof'] ?? 'img/default-profile.png'; // Image par défaut
$nom = $_SESSION['nom'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];

    if (isset($_FILES['tof']) && $_FILES['tof']['error'] == UPLOAD_ERR_OK) {
        $uploads_dir = 'img/'; 
        $tmp_name = $_FILES['tof']['tmp_name'];
        $name = $_FILES['tof']['name'];
        $path = $uploads_dir . basename($name);

        // Vérifiez que le fichier est une image
        $check = getimagesize($tmp_name);
        if ($check !== false) {
            if (move_uploaded_file($tmp_name, $path)) {
                $_SESSION['tof'] = $path;
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        } else {
            echo "Le fichier téléchargé n'est pas une image.";
        }
    }

    // Mettre à jour les informations de session
    $_SESSION['nom'] = $nom;
    $_SESSION['email'] = $email;
    $_SESSION['tof'] = $tof;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Docteur</title>
    
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
    <style>
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 90px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .profile-picture {
            position: relative;
            margin-right: 20px;
        }

        .profile-picture img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 2px solid #4CAF50;
        }

        input[type="file"] {
            display: none;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<section id="sidebar">
    <?php include("../../inc/sidebar4.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav4.php"); ?>
    </nav>
    <main>
        <div class="container">
            <div class="profile-header">
                <div class="profile-picture">
                <img src="../../<?php echo htmlspecialchars($tof); ?>" alt="">
                    <input type="file" id="uploadBtn" name="tof" accept="image/*" onchange="previewImage(event)">
                </div>
                <button type="button" onclick="document.getElementById('uploadBtn').click()">Modifier la Photo</button>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?php echo htmlspecialchars($nom); ?>" required>
                </div>
                
                <div>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" placeholder="Votre email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                
                <div>
                    <button type="submit">Sauvegarder les Modifications</button>
                </div>
            </form>
        </div>
        <?php
        
$role = $_SESSION['role'] ?? "administrateur";
?>
     <?php if ($role == "docteur") { ?>
    <video id="localVideo" autoplay muted></video>
    <video id="remoteVideo" autoplay></video>
    <button id="startCall"> <i class="fa fa-video-camera icon" aria-hidden="true"></i> Démarrer l'appel </button>
    <button id="endCall" > <i class="fa fa-phone-slash icon" aria-hidden="true"></i> Terminer l'appel </button>
<?php } else if ($role == "patient") { ?>
    <video id="localVideo" autoplay muted></video>
    <video id="remoteVideo" autoplay></video>
    <button id="answerCall">Répondre à l'appel</button>
    <button id="endCall" > <i class="fa fa-phone-slash icon" aria-hidden="true"></i> Terminer l'appel </button>
<?php } else if ($role == "administrateur") { ?>
    <h2>Administrateur</h2>
    <p>Vous pouvez gérer les utilisateurs ici.</p>
<?php } ?>
</div>
</div>

<script>
    const localVideo = document.getElementById('localVideo');
    const remoteVideo = document.getElementById('remoteVideo');
    let localStream;
    let peerConnection;
    const socket = new WebSocket('ws://localhost:8080');

    socket.onopen = () => {
        console.log("Connecté au serveur WebSocket");
    };

    socket.onmessage = async (event) => {
        const message = JSON.parse(event.data);
        console.log("Message reçu:", message);
        if (message.type === 'offer') {
            await answerCall(message);
        } else if (message.type === 'answer') {
            await peerConnection.setRemoteDescription(new RTCSessionDescription(message));
        }
    };

    // Fonction pour le médecin
    document.getElementById('startCall')?.addEventListener('click', async () => {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localVideo.srcObject = localStream;

        peerConnection = new RTCPeerConnection();
        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

        peerConnection.ontrack = event => {
            remoteVideo.srcObject = event.streams[0];
        };

        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        console.log("Offre envoyée:", offer);
        socket.send(JSON.stringify({ type: 'offer', sdp: offer.sdp }));

        // Afficher le bouton Terminer l'appel
        document.getElementById('startCall').style.display = 'none';
        document.getElementById('endCall').style.display = 'block';
    });

    // Fonction pour le patient
    async function answerCall(offer) {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localVideo.srcObject = localStream;

        peerConnection = new RTCPeerConnection();
        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

        peerConnection.ontrack = event => {
            remoteVideo.srcObject = event.streams[0];
        };

        await peerConnection.setRemoteDescription(new RTCSessionDescription(offer));
        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        console.log("Réponse envoyée:", answer);
        socket.send(JSON.stringify({ type: 'answer', sdp: answer.sdp }));

        // Afficher le bouton Terminer l'appel
        document.getElementById('endCall').style.display = 'block';
    }

    // Gestion de la terminaison de l'appel
    document.getElementById('endCall').onclick = () => {
        // Terminer l'appel
        if (peerConnection) {
            peerConnection.close();
            peerConnection = null;
        }
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
        }

        // Réinitialiser les vidéos
        localVideo.srcObject = null;
        remoteVideo.srcObject = null;

        // Réinitialiser les boutons
        document.getElementById('startCall').style.display = 'block';
        document.getElementById('endCall').style.display = 'none';
    };
</script>


        
    </main>

    <script src="../../js/all.min.js"></script>
</body>
</html>
