<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Traitement du formulaire
$msgSuccess = '';
$msgErreur = '';

if (isset($_POST['submit'])) {
    if (isset($_POST['patient'], $_POST['dob'], $_POST['medicament'], $_POST['dosage'], $_POST['posologie'], $_POST['docteur'])) {
        if (!empty($_POST['patient']) && !empty($_POST['dob']) && !empty($_POST['medicament']) && !empty($_POST['dosage']) && !empty($_POST['posologie']) && !empty($_POST['docteur'])) {
            $patient = $_POST["patient"];
            $dob = $_POST["dob"];
            $medicament = $_POST["medicament"];
            $dosage = $_POST["dosage"];
            $posologie = $_POST["posologie"];
            $docteur = $_POST["docteur"];

            try {
                // Insertion dans la base de données
                $insert = $pdo->prepare("INSERT INTO ordonnance (patient, dob, medicament, dosage, posologie, docteur) VALUES (?, ?, ?, ?, ?, ?)");
                $execute = $insert->execute([$patient, $dob, $medicament, $dosage, $posologie, $docteur]);

                if ($execute) {
                    $msgSuccess = "L'ordonnance a été créée avec succès.";
                    $ordonnanceDetails = [
                        'patient' => $patient,
                        'dob' => $dob,
                        'medicament' => $medicament,
                        'dosage' => $dosage,
                        'posologie' => $posologie,
                        'docteur' => $docteur,
                        'date' => date('Y-m-d')
                    ];
                } else {
                    $msgErreur = "Échec de l'insertion de l'ordonnance.";
                    $errorInfo = $insert->errorInfo();
                    echo "Erreur SQL: " . $errorInfo[2]; // Afficher l'erreur SQL
                }
            } catch (PDOException $e) {
                $msgErreur = "Erreur: " . $e->getMessage();
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}

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
