<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}
$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
$iddocteur = $_SESSION['iddocteur'];
// Connexion à la base de données
require_once("../../inc/connexion.php");

// Récupérer tous les patients
$sql = "SELECT DISTINCT patient.* 
                        FROM patient 
                        JOIN consultation ON patient.idpatient = consultation.idpatient 
                        WHERE consultation.iddocteur = :iddocteur";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':iddocteur', $iddocteur);
                $stmt->execute();
                $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Patients</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
</head>
<body>
<section id="sidebar">
    <?php include("../../inc/sidebar4.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav4.php"); ?>
    </nav>
<h2>Liste des Patients</h2>
    <ul>
        <?php foreach ($patients as $patient): ?>
            <li>
                <?php echo htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']); ?>
                <a href="dossiermedical.php?idpatient=<?php echo $patient['idpatient']; ?>" class="btn">Voir Dossier</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <script src="../../js/all.min.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>
