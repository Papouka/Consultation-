<?php
session_start();


if (!isset($_SESSION['email'])) {
   header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];


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
                 <?php include("../pages/chat/chat.php"); ?> 
            </div>   
        </main>
    </section>
    <script src="../js/all.min.js"></script>
    <script src="../js/chart.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
