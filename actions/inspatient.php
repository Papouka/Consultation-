<?php

session_start();
$msgErreur = ""; 

require_once('inc/connexion.php');

// Traitement du formulaire
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['email'], $_FILES['tof'], $_POST['mdp'])) {
        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['mdp'])) {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT); 
            

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
            $sql = "SELECT * FROM patient WHERE email=?";
            $stm = $pdo->prepare($sql);
            $stm->execute([$email]);
            if ($stm->rowCount() > 0) {
                $msgErreur = "Cette adresse e-mail est déjà utilisée.";
            } else {
                try {
                    // Insertion dans la base de données
                    $insert = $pdo->prepare("INSERT INTO patient (nom, prenom, tel, email, tof, mdp) VALUES (?, ?, ?, ?, ?, ?)");
                    $execute = $insert->execute([$nom, $prenom, $tel, $email, $tofPath, $mdp]);
                    
                    // Récupérer l'ID du patient nouvellement inséré
                    $idpatient = $pdo->lastInsertId();

                    // Créer le dossier médical pour le patient
                    $insertDossier = $pdo->prepare("INSERT INTO dossiermedical (idpatient) VALUES (?)");
                    $insertDossier->execute([$idpatient]);

                    $_SESSION['nom'] = $nom;
                    $_SESSION['tof'] = $tofPath;
                    header("Location: pages/symptome.php");
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

$stmt = $pdo->prepare("SELECT * FROM specialiste");
$stmt->execute();
$specialiste = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
