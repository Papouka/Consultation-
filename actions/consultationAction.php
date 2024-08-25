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
if (!isset($_SESSION['idpatient'])) {
    die("Erreur : L'identifiant du patient n'est pas défini.");
}

// Récupérer les consultations du patient
try {
    $query = "SELECT c.*, d.nom AS nom_docteur, d.prenom AS prenom_docteur 
              FROM consultation c 
              JOIN docteur d ON c.iddocteur = d.iddocteur 
              WHERE c.idpatient = :idpatient";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['idpatient' => $_SESSION['idpatient']]);
    $consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des consultations : " . $e->getMessage();
    exit();
}
?>