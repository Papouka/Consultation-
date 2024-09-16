<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}
$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
require_once("../../inc/connexion.php");
// Vérifiez si l'identifiant du patient est défini
if (isset($_GET['iddocteur'])) {
    $idpatient = $_GET['iddocteur'];
    $iddocteur = $_SESSION['idpatient'];
}

// Récupérer les consultations du patient
try {
    
    $stmt = $pdo->prepare("SELECT * FROM consultation   JOIN docteur  ON consultation.iddocteur = docteur.iddocteur  JOIN specialiste 
     ON docteur.idspecialiste = specialiste.idspecialiste ");
    $stmt->execute();
    $consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des consultations : " . $e->getMessage();
    exit();
}
?>