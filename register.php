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
                $tofPath = 'img/' . basename($_FILES['tof']['name']);
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
                    $insert = $pdo->prepare("INSERT INTO user (nom, prenom, tel, email, tof, mdp) VALUES (?, ?, ?, ?, ?, ?)");
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Patient</title>
    <link rel="stylesheet" href="css/docteur.css">
</head>
<body>
    <div id="page" class="site">
        <div class="container">
            <div class="form-box">
                <form action="" method="POST" enctype="multipart/form-data"> <!-- Ajout de l'attribut enctype -->
                    <?php if (!empty($msgErreur)): ?> <!-- Vérification si le message d'erreur n'est pas vide -->
                        <div style="color: red;"><?= htmlspecialchars($msgErreur) ?></div>
                    <?php endif; ?>
                    <h2>Entrer vos informations personnelles</h2>
                    <div>
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" placeholder="Votre nom" required>
                    </div> 
                    <div>
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" placeholder="Votre prénom" required>
                    </div>
                    <div>
                        <label for="tel">Numéro de téléphone</label>
                        <input type="tel" name="tel" placeholder="Votre numéro de téléphone" required>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Votre email" required>
                    </div>
                    <div>
                        <label for="tof">Photo de profil</label>
                        <input type="file" name="tof" accept="image/*" required> <!-- Champ pour le téléchargement de la photo -->
                    </div>
                    <div>
                        <label for="mdp">Mot de passe</label>
                        <input type="password" name="mdp" placeholder="Votre mot de passe" required>
                    </div>
                    
                    <button type="submit" name="submit" class="btn-submit">ENVOYER</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
