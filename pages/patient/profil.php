<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof'] ?? 'img/default-profile.png'; 
$nom = $_SESSION['nom'];


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

        .info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h3{
            text-align: center;
        }
        .profile-card img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
            border: 4px solid #580770FF;
            transition: transform 0.3s ease;
            position: relative;
        }

        .profile-card img:hover {
            transform: scale(1.1);
        }

        .camera-icon {
            position: absolute;
            top: 110px; 
            left: calc(50% + 53px); 
            transform: translateX(-50%);
            font-size: 24px;
            color: #0A0C0BFF;
            background-color: #580770FF;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }
        input[type="file"] {
            display: none;
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
                    <img src="../../<?php echo htmlspecialchars($tof); ?>" alt="Photo de profil" id="profileImage">
                    <label for="fileInput">
        <i class="fas fa-camera camera-icon"></i>
    </label>

    <input type="file" id="fileInput" accept="image/*" onchange="changePhoto(event)">
                </div>
            </div>

            <div class="info">
                <h3>Mes informations :</h3>
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
                
            </div>
        </div>
    </main>

    <script src="../../js/all.min.js"></script>
    <script src="../../js/serveur.js"></script>
    <script>
    // Fonction pour changer la photo de profil en temps réel
    function changePhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remplacer l'image de profil par la nouvelle
                document.getElementById('profileImage').src = e.target.result;

                // Envoi de l'image au serveur
                uploadImage(file);
            };
            reader.readAsDataURL(file);
        }
    }

    function uploadImage(file) {
        const formData = new FormData();
        formData.append('tof', file);

        fetch('user.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text()) // Changer ici pour récupérer le texte
        .then(data => {
            // Afficher le message de succès dans la div
            document.getElementById('message').innerText = data; // Affiche le message
        })
        .catch((error) => {
            console.error('Erreur lors de l\'enregistrement de l\'image :', error);
            document.getElementById('message').innerText = "Erreur lors de l'upload.";
        });
    }
</script>
</body>
</html>
