<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof'];
$nom = $_SESSION['nom'];
$iddocteur = $_SESSION['docteur']; 

require_once("../inc/connexion.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmer un Rendez-vous</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../icons/all.min.css">
</head>
<body>
<section id="sidebar">
    <?php include("../inc/sidebar4.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../inc/nav4.php"); ?>
    </nav>
    <main>
    <?php
            if (isset($_GET['lien'])) {
                $lien = $_GET['lien']; 
                echo ' <iframe src="'.$lien.'" style="position: absolute;  width: 95%; height: 30pc;" allowfullscreen></iframe>';
            }
        ?>
   

    </main>
    <script src="../js/all.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html> 
