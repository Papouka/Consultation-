<?php
session_start();
require_once("../../inc/connexion.php");
// Vérification de la session
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
// Connexion à la base de données


// Initialisation des messages
$msgSuccess = '';
$msgErreur = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des valeurs du formulaire
    
    $dateconsultation = $_POST['dateconsultation'];
    $heure = $_POST['heure'];
    
    $diagnostic = $_POST['diagnostic'];
    $traitement = $_POST['traitement'];
   

    // Vérification des champs
    if ( !empty($dateconsultation) && !empty($heure) &&  !empty($diagnostic) && !empty($traitement)) {
        // Insertion dans la base de données
        try {
            $stmt = $pdo->prepare("INSERT INTO consultation ( dateconsultation, heure, diagnostic, traitement) 
                                   VALUES ( ?, ?, ?, ?)");
            $stmt->execute([ $dateconsultation, $heure, $diagnostic, $traitement]);
            $msgSuccess = "Consultation ajoutée avec succès.";
        } catch (PDOException $e) {
            $msgErreur = "Erreur lors de l'ajout de la consultation : " . $e->getMessage();
        }
    } else {
        $msgErreur = "Tous les champs sont requis.";
    }
}
?>
