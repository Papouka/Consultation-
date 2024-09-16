<?php
// docteur.php - Configuration de la connexion à la base de données
session_start();
$msgErreur = ""; // Initialisation de la variable

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Traitement du formulaire
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['email'], $_FILES['tof'], $_POST['mdp'])) {
        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['mdp'])) {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT); // Crypter le mot de passe
            

            // Vérification du téléchargement de la photo
            if ($_FILES['tof']['error'] == UPLOAD_ERR_OK) {
                $tofPath = '../img/' . basename($_FILES['tof']['name']);
                if (!move_uploaded_file($_FILES['tof']['tmp_name'], $tofPath)) {
                    $msgErreur = "Erreur lors du téléchargement de la photo de profil.";
                }
            } else {
                $msgErreur = "Erreur lors du téléchargement de la photo de profil.";
            }

            // Vérification de l'email
            $sql = "SELECT * FROM administrateur WHERE email=?";
            $stm = $pdo->prepare($sql);
            $stm->execute([$email]);
            if ($stm->rowCount() > 0) {
                $msgErreur = "Cette adresse e-mail est déjà utilisée.";
            } else {
                try {
                    // Insertion dans la base de données
                    $insert = $pdo->prepare("INSERT INTO administrateur (nom, prenom, tel, email, tof, mdp) VALUES (?, ?, ?, ?, ?, ?)");
                    $execute = $insert->execute([$nom, $prenom, $tel, $email, $tofPath, $mdp]);
                    $_SESSION['nom'] = $nom;
                    $_SESSION['tof'] = $tofPath;
                    header("Location: index.php");
                    exit();
                } catch (PDOException $e) {
                    $msgErreur = "Erreur: " . $e->getMessage();
                }
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, in itial-scale=1.0">
    <link rel="stylesheet" href="icons/all.min.css">
    <script src="../js/all.min.js"></script>
    <link rel="stylesheet" href="../css/patient.css">
    <link rel="stylesheet" href="../css/index.css">
    
    <title>Document</title>
    
</head>
<body>
    
<header>
<?php include("../inc/header.php"); ?>
    </header>

    <div id="page" class="site">
        <div class="contain">
            <div class="form-box">
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form one form-step active">
                        <h2>Entrer vos informations personnelles</h2>
                        <div>
                            
                            <input type="text" name="nom" placeholder="Votre nom" required>
                        </div> 
                        <div>
                            
                            <input type="text" name="prenom" placeholder="Votre prénom" required>
                        </div>
                        <div>
                            
                            <input type="tel" name="tel" placeholder="Votre numéro de téléphone" required>
                        </div>
                        <div>
                        
                            <input type="email" name="email" placeholder="Votre email" required>
                        </div>
                        
                        
                        <div>
                            <label>Votre photo de profil</label>
                            <input type="file" id="imageUpload" name="tof" accept="image/*" required>
                        
                        <div>
                            
                            <input type="password" name="mdp" placeholder="Votre mot de passe" required>
                        </div>
                    </div>

                    <div class="btn-group">
                        
                        <button type="submit" name="submit" class="btn-submit" >ENVOYER</button>
                    </div>
                </form>
                
                <?php if ($msgErreur): ?>
                    <div class="error-message"><?php echo $msgErreur; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<footer>
<?php include("../inc/footer.php"); ?>
</footer>
<script src="../js/accueil.js"></script>
