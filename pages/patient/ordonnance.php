<?php
require_once("../../actions/ordonnanceAction.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Docteur</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
    <style>
      .form {
          font-family: Arial, sans-serif;
          margin: 20px;
          padding: 20px;
          border: 1px solid #ccc;
          border-radius: 5px;
         background-color: #fff;
      }
      h1 {
          text-align: center;
      }
      .form-group {
          margin-bottom: 15px;
      }
      label {
          display: block;
          margin-bottom: 5px;
      }
      input, select {
          width: 100%;
          padding: 8px;
          margin-top: 5px;
      }
      button {
          padding: 10px 15px;
          background-color: #4CAF50;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
      }
      button:hover {
          background-color: #45a049;
      }
  </style>
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
        <h1>Générateur d'Ordonnance</h1>
        <form method="POST" class="form">
            <div class="form-group">
                <label for="patientName">Nom du Patient</label>
                <input type="text" name="patient" id="patientName" required>
            </div>
            <div class="form-group">
                <label for="patientDOB">Date de Naissance</label>
                <input type="date" name="dob" id="patientDOB" required>
            </div>
            <div class="form-group">
                <label for="medicament">Médicament</label>
                <input type="text" name="medicament" id="medicament" required>
            </div>
            <div class="form-group">
                <label for="dosage">Dosage</label>
                <input type="text" name="dosage" id="dosage" required>
            </div>
            <div class="form-group">
                <label for="posologie">Posologie</label>
                <input type="text" name="posologie" id="posologie" required>
            </div>
            <div class="form-group">
                <label for="doctorName">Nom du Médecin</label>
                <input type="text" name="docteur" id="doctorName" required>
            </div>
            <button type="submit" name="submit">Générer l'Ordonnance</button>
        </form>

        <!-- Affichage des messages de succès ou d'erreur -->
        <?php if (!empty($msgSuccess)): ?>
            <div style="margin-top: 20px; color: green;">
                <h2>Ordonnance Générée</h2>
                <p><strong>Nom du Patient :</strong> <?php echo $ordonnanceDetails['patient']; ?></p>
                <p><strong>Date de Naissance :</strong> <?php echo $ordonnanceDetails['dob']; ?></p>
                <p><strong>Médicament :</strong> <?php echo $ordonnanceDetails['medicament']; ?></p>
                <p><strong>Dosage :</strong> <?php echo $ordonnanceDetails['dosage']; ?></p>
                <p><strong>Posologie :</strong> <?php echo $ordonnanceDetails['posologie']; ?></p>
                <p><strong>Nom du Médecin :</strong> <?php echo $ordonnanceDetails['docteur']; ?></p>
                <p><strong>Date de l'ordonnance :</strong> <?php echo $ordonnanceDetails['date']; ?></p>
            </div>
        <?php elseif (!empty($msgErreur)): ?>
            <p style="color: red;"><?php echo $msgErreur; ?></p>
        <?php endif; ?>
    </main>
</section>

<script src="../../js/all.min.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>
