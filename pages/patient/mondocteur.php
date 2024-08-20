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
    <title>Mon Docteur</title>
    
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
<main>
    <section class="doctor-info">
        <h2>Informations sur mon médecin</h2>
        <p><strong>Nom :</strong> Dr. </p>
        <p><strong>Spécialité :</strong> </p>
        <p><strong>Téléphone :</strong> </p>
        <p><strong>Email :</strong> </p>
        
    </section>

   
</main>

<script src="../../js/all.min.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>
