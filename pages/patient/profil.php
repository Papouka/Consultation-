<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $nom = $_POST['nom'];
    $email = $_POST['email'];

    if (isset($_FILES['tof']) && $_FILES['tof']['error'] == UPLOAD_ERR_OK) {
        $uploads_dir = 'img/'; 
        $tmp_name = $_FILES['tof']['tmp_name'];
        $name = basename($_FILES['tof']['name']);
        $path = $uploads_dir . $name;

       
        if (move_uploaded_file($tmp_name, $path)) {
            
            $_SESSION['tof'] = $path;
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    }
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
</head>
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
                    <img src="<?php echo htmlspecialchars($tof); ?>" alt="Photo de Profil" id="profileImg">
                    <input type="file" id="uploadBtn" accept="image/*" onchange="previewImage(event)">
                </div>
                <button type="button" onclick="document.getElementById('uploadBtn').click()">Modifier la Photo</button>
            </div>

            <form action="#" method="POST">
                <div>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?php echo htmlspecialchars($nom); ?>" required>
                </div>
                
                <div>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" placeholder="Votre email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                
                <div>
                   <a href="pages/patient/profil.php"> <button type="submit">Sauvegarder les Modifications</button></a>
                </div>
            </form>
           
        </div>
        
        
<video id="localVideo" autoplay muted></video>
<video id="remoteVideo" autoplay></video>
<button id="startCall"> <i class="fa fa-video-camera icon" aria-hidden="true"></i> </button>

            <script>
                
const localVideo = document.getElementById('localVideo');
const remoteVideo = document.getElementById('remoteVideo');
let localStream;
let peerConnection;

const startCallButton = document.getElementById('startCall');
startCallButton.onclick = startCall;

async function startCall() {
    localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    localVideo.srcObject = localStream;

    // Configuration de la connexion
    peerConnection = new RTCPeerConnection();
    localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

    peerConnection.ontrack = event => {
        remoteVideo.srcObject = event.streams[0];
    };

    // Ajoutez ici le code pour échanger les offres et les réponses
}


            </script>


        <script>
            function previewImage(event) {
                const img = document.getElementById('profileImg');
                img.src = URL.createObjectURL(event.target.files[0]);
            }
        </script>
    </main>

    <script src="../../js/all.min.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
