<?php
session_start();

require_once("../inc/connexion.php");

if (!isset($_SESSION['email'])) {
   header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
$iddocteur = $_SESSION['docteur']; 
$idpatient = $_SESSION['patient']; 

$stmt1 = $pdo->prepare("SELECT * FROM rendezvous WHERE iddocteur = :iddocteur"); 
$stmt1->bindParam(':iddocteur', $iddocteur, PDO::PARAM_INT);
$stmt1->execute();
$nbre = $stmt1->fetchColumn();


$stmt = $pdo->prepare("SELECT COUNT(*) FROM rendezvous WHERE is_read = 0 AND iddocteur = :iddocteur");
$stmt->bindParam(':iddocteur', $iddocteur, PDO::PARAM_INT);
$stmt->execute();
$nbre = $stmt->fetchColumn();


$stm = $pdo->prepare("SELECT * FROM video WHERE idpatient = :idpatient"); 
$stm->bindParam(':idpatient', $idpatient, PDO::PARAM_INT);
$stm->execute();
$number = $stm->fetchColumn();

$stm1 = $pdo->prepare("SELECT COUNT(*) FROM video WHERE is_read = 0 AND idpatient = :idpatient");
$stm1->bindParam(':idpatient', $idpatient, PDO::PARAM_INT);
$stm1->execute();
$number = $stm1->fetchColumn();

?>


<!DOCTYPE html>
<html lang="fr"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCUEIL</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../icons/all.min.css">
</head>

<body>
    <section id="sidebar">
        <?php include("../inc/sidebar.php"); ?>
    </section>
    <section id="content">
        <nav>
            <?php include("../inc/nav.php"); ?>
        </nav>
        <main>
            <h1 class="title">Dashboard</h1>
             
            <ul class="breadcrumbs">
                <li><a href="index.php">Accueil</a></li> 
                <li class="divider">/</li>
                <li><a href="" class="active">Dashboard</a></li>
            </ul>
            <div class="info-data">
                <?php include("../inc/card.php"); ?>
            </div>
            <div class="data">
                <?php include("../inc/chart.php"); ?>
               <!--
            <?php include("../pages/chat/chat.php"); ?>
                -->

            </div>   
        </main>
    </section>
    <script src="../js/all.min.js"></script>
    <script src="../js/chart.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
