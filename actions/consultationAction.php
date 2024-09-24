<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['patient'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
$idpatient = $_SESSION['patient'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les consultations du patient connecté
    $stmt = $pdo->prepare("
       SELECT consultation.dateconsultation, docteur.nom, docteur.prenom, specialiste.nomspecialiste 
       FROM consultation JOIN docteur ON consultation.iddocteur = docteur.iddocteur 
       JOIN specialiste ON consultation.idspecialiste = specialiste.idspecialiste
        WHERE consultation.idpatient = ?
      
    ");
    $stmt->execute([$idpatient]);
    $consultation = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
