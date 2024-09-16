<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$msgErreur = ""; // Initialisation de la variable d'erreur

require_once('inc/connexion.php');

// Traitement du formulaire
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['email'], 
              $_FILES['tof'], $_FILES['cni'], $_POST['idspecialiste'], 
              $_POST['grade'], $_FILES['diplome'], $_FILES['certificat'], 
              $_POST['experience'], $_POST['mdp'])) {
        
        // Vérification des champs requis
        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && 
            !empty($_POST['email']) && !empty($_POST['idspecialiste']) && 
            !empty($_POST['grade']) && !empty($_POST['experience']) && 
            !empty($_POST['mdp'])) {
            
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            $idspecialiste = $_POST["idspecialiste"];
            $grade = $_POST["grade"];
            $experience = $_POST["experience"];
            $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
            
            // Gestion des fichiers
            $cniPath = $tofPath = $diplomePath = $certificatPath = null;

            $uploadErrors = false;

            // Téléchargement de la CNI
            if ($_FILES['cni']['error'] == UPLOAD_ERR_OK) {
                $cniPath = 'img/' . basename($_FILES['cni']['name']);
                if (!move_uploaded_file($_FILES['cni']['tmp_name'], $cniPath)) {
                    $msgErreur = "Erreur lors du déplacement de la CNI.";
                    $uploadErrors = true;
                }
            } else {
                $msgErreur = "Erreur lors du téléchargement de la CNI.";
                $uploadErrors = true;
            }

            // Téléchargement de la photo de profil
            if ($_FILES['tof']['error'] == UPLOAD_ERR_OK) {
                $tofPath = 'img/' . basename($_FILES['tof']['name']);
                if (!move_uploaded_file($_FILES['tof']['tmp_name'], $tofPath)) {
                    $msgErreur = "Erreur lors du déplacement de la photo de profil.";
                    $uploadErrors = true;
                }
            } else {
                $msgErreur = "Erreur lors du téléchargement de la photo de profil.";
                $uploadErrors = true;
            }

            // Téléchargement du diplôme
            if ($_FILES['diplome']['error'] == UPLOAD_ERR_OK) {
                $diplomePath = 'img/' . basename($_FILES['diplome']['name']);
                if (!move_uploaded_file($_FILES['diplome']['tmp_name'], $diplomePath)) {
                    $msgErreur = "Erreur lors du déplacement du diplôme.";
                    $uploadErrors = true;
                }
            } else {
                $msgErreur = "Erreur lors du téléchargement du diplôme.";
                $uploadErrors = true;
            }

            // Téléchargement du certificat
            if ($_FILES['certificat']['error'] == UPLOAD_ERR_OK) {
                $certificatPath = 'img/' . basename($_FILES['certificat']['name']);
                if (!move_uploaded_file($_FILES['certificat']['tmp_name'], $certificatPath)) {
                    $msgErreur = "Erreur lors du déplacement du certificat.";
                    $uploadErrors = true;
                }
            } else {
                $msgErreur = "Erreur lors du téléchargement du certificat.";
                $uploadErrors = true;
            }

            if ($uploadErrors) {
                // Si une erreur s'est produite lors du téléchargement, ne pas continuer
                $msgErreur .= " Vérifiez les erreurs de téléchargement.";
            } else {
                // Vérification de l'email
                $sql = "SELECT * FROM docteur WHERE email=?";
                $stm = $pdo->prepare($sql);
                $stm->execute([$email]);
                if ($stm->rowCount() > 0) {
                    $msgErreur = "Cette adresse e-mail est déjà utilisée.";
                } else {
                    // Insertion des données dans la base de données
                    try {
                        $insert = $pdo->prepare("INSERT INTO docteur (nom, prenom, tel, email, tof, cni, idspecialiste, grade, diplome, certificat, experience, mdp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $insert->execute([$nom, $prenom, $tel, $email, $tofPath, $cniPath, $idspecialiste, $grade, $diplomePath, $certificatPath, $experience, $mdp]);
                        $_SESSION['nom'] = $nom;
                        $_SESSION['tof'] = $tofPath;
                        header("Location: pages/accueil.php");
                        exit();
                    } catch (PDOException $e) {
                        $msgErreur = "Erreur lors de l'insertion: " . $e->getMessage();
                    }
                }
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}

$sql1 = "SELECT * FROM specialiste";
$stm1 = $pdo->prepare($sql1);
$stm1->execute();
$specialistes = $stm1->fetchAll(PDO::FETCH_ASSOC);
?>