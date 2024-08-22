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
    <title>Consultation Médicale</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
</head>
<body>
 <style>
  
.form{
    font-family: Arial, sans-serif;
          margin: 20px;
          padding: 20px;
          border: 1px solid #ccc;
          border-radius: 5px;
          background-color: #f9f9f9;
}


main {
    padding: 20px;
}

.form-group {
          margin-bottom: 15px;
      }

h2 {
    margin-bottom: 20px;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input {
    width: 100%;
          padding: 8px;
          margin-top: 5px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background: green;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    align-items: center;
    width: 20%;
}



 </style>

<section id="sidebar">
        <?php include("../../inc/sidebar4.php"); ?>
    </section>
    <section id="content">
        <nav>
            <?php include("../../inc/nav4.php"); ?>
        </nav>
<main>

    <section class="appointment-form">
        
        <form action="#" method="POST" class="form">
        <h2>Formulaire de Prise de Rendez-vous</h2>

            <div class="form-group"><label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group"><label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group"> <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group"> <label for="telephone">Téléphone:</label>
            <input type="tel" id="telephone" name="telephone" required>
            </div>
            <div class="form-group"> <label for="date">Date de Rendez-vous:</label>
            <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group"> <label for="heure">Heure de Rendez-vous:</label>
            <input type="time" id="heure" name="heure" required><br><br>
            </div>
            <button type="submit">Programmer le Rendez-vous</button>
        </form>
    </section>
</main>


<script src="../../js/all.min.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>
