<?php
session_start();
$error = "";

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("inc/connexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $role = $_POST['role']; 
    
    if ($role == 'patient') {
        $sql = "SELECT * FROM patient WHERE email=?";
    } else {
        $sql = "SELECT * FROM docteur WHERE email=?";
    }
    
    $stm = $pdo->prepare($sql);
    try {
        $stm->execute([$email]); 
    } catch (PDOException $e) {
        die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
    }

    if ($stm->rowCount() > 0) {
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        // Vérification du mot de passe
        
            // Vérification du mot de passe
        if (password_verify($mdp, $row['mdp'])) { 
            $_SESSION['email'] = $email;
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['tof'] = $row['tof'];
            $_SESSION['role'] = $role;
            $_SESSION['patient'] = $row['idpatient'] ?? null; 
            $_SESSION['docteur'] = $row['iddocteur'] ?? null; 
            header("Location: pages/accueil.php");
        } else {
            $error = "Adresse mail ou mot de passe incorrecte";
        }
    } else {
    
        $error = "Adresse mail ou mot de passe incorrecte";
    }
}
?>