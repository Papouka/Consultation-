<?php
session_start();
$msgErreur = ""; 

require_once('inc/connexion.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['email'],$_POST['dob'], $_POST['mdp'])) {
        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['dob']) && !empty($_POST['mdp'])) {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            $dob = $_POST["dob"];
            $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
            
            // Gestion du téléchargement de la photo de profil
            if ($_FILES['tof']['error'] == UPLOAD_ERR_OK) {
                $tofPath = 'img/' . basename($_FILES['tof']['name']);
                if (!move_uploaded_file($_FILES['tof']['tmp_name'], $tofPath)) {
                    $msgErreur = "Erreur lors du téléchargement de la photo de profil.";
                }
            } else {
                
                    $tof = '5.png';
                    $tofPath = 'img/' . $tof;
                    move_uploaded_file($tof, $tofPath);
                
            }

            // Vérification de l'email
            $sql = "SELECT * FROM patient WHERE email=?";
            $stm = $pdo->prepare($sql);
            $stm->execute([$email]);
            if ($stm->rowCount() > 0) {
                $msgErreur = "Cette adresse e-mail est déjà utilisée.";
            } else {
                try {
                    // Insertion du patient
                    $insert = $pdo->prepare("INSERT INTO patient (nom, prenom, tel, email,dob, tof, mdp) VALUES (?,?, ?, ?, ?, ?, ?)");
                    $insert->execute([$nom, $prenom, $tel, $email,$dob, $tofPath, $mdp]);

                    // Récupérer l'ID du patient nouvellement inséré
                    $idpatient = $pdo->lastInsertId();
                    $_SESSION['email'] = $email;
                    
                    // Détails de la consultation initiale
                    $description = "Consultation initiale"; 
                    $duree = 30; 
                    $idspecialiste = 1; 

                    // Insertion de la consultation
                    $insertDossier = $pdo->prepare("INSERT INTO consultation (description, duree, idspecialiste, idpatient) VALUES (?, ?, ?, ?)");
                    $insertDossier->execute([$description, $duree, $idspecialiste, $idpatient]);

                    $_SESSION['nom'] = $nom;
                    $_SESSION['tof'] = $tofPath;
                    header("Location: pages/symptome.php");
                    exit();
                } catch (PDOException $e) {
                    $msgErreur = "Erreur: " . htmlspecialchars($e->getMessage());
                }
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}

// Fonction pour générer le PDF du dossier médical
function viewMedicalFilePDF($medical) {
    require_once("inc/dompdf/autoload.inc.php");
    $dompdf = new Dompdf\Dompdf();

    // Créer le contenu HTML du PDF
    $html = '<h1>Dossier Médical</h1>';
    $html .= '<p>Nom  : ' . htmlspecialchars($medical['nom']) . '</p>';
    $html .= '<p>Prenom : ' . htmlspecialchars($medical['prenom']) . '</p>';
    $html .= '<p>Telephone : ' . htmlspecialchars($medical['tel']) . '</p>';
    $html .= '<p>Email : ' . htmlspecialchars($medical['email']) . '</p>';
    $html .= '<p>Date de naissance : ' . htmlspecialchars($medical['dob']) . '</p>';
    // Charger le contenu HTML dans Dompdf
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Enregistrer le PDF sur le serveur
    $pdfOutputPath = 'dossiers/dossier_medical_' . htmlspecialchars($medical['nom']) . '_' . htmlspecialchars($medical['prenom']) . '.pdf';
    file_put_contents($pdfOutputPath, $dompdf->output()); 

    
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
    <link rel="stylesheet" href="../icons/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="../js/all.min.js"></script>
    <style>
        
        .site {
            max-width: 800px;
            margin: auto;
            margin-top: 7vh;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .container {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(img/30.jpg);
            background-size: cover;
            background-position: center;
            margin-top: 2vh;
            height: 100vh;
        }

        h2 {
            color: #343a40;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #495057;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        button {
            background-color: hsl(158, 97%, 29%);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: green;
            transform: translateY(-2px);
        }

        .error-message {
            color: #f44336;
            background-color: #f8d7da;
            padding: 10px;
            border: 1px solid #f44336;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <?php include("inc/header.php"); ?>
    </header>
    <div class="container">
        <form class="site" action="" method="POST" enctype="multipart/form-data">
            <h2>Entrer vos informations personnelles</h2>
            <?php if ($msgErreur): ?>
                <div class="error-message"><?php echo $msgErreur; ?></div>
            <?php endif; ?>
            <input type="text" name="nom" placeholder="Votre nom" required>
            <input type="text" name="prenom" placeholder="Votre prénom" required>
            <input type="tel" name="tel" placeholder="Votre numéro de téléphone" required>
            <input type="email" name="email" placeholder="Votre email" required>
            <input type="date" name="dob" placeholder="Votre date de naissance" required>
            <input type="password" name="mdp" placeholder="Votre mot de passe" required>
            <label>Votre photo de profil</label>
            <input type="file" id="imageUpload" name="tof" accept="image/*" >
            <button type="submit" name="submit" class="btn-submit">ENVOYER</button>
        </form>
    </div>
    
    <footer>
        <?php include("inc/footer.php"); ?>
    </footer>
    <script src="js/accueil.js"></script>
</body>
</html>
