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
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['email'], $_FILES['tof'], $_POST['mdp'])) {
        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && !empty($_POST['email']) && !empty($_POST['mdp'])) {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT); // Crypter le mot de passe
            

            // Vérification du téléchargement de la photo
            if ($_FILES['tof']['error'] == UPLOAD_ERR_OK) {
                $tofPath = 'img/' . basename($_FILES['tof']['name']);
                if (!move_uploaded_file($_FILES['tof']['tmp_name'], $tofPath)) {
                    $msgErreur = "Erreur lors du téléchargement de la photo de profil.";
                }
            } else {
                $msgErreur = "Erreur lors du téléchargement de la photo de profil.";
            }

            // Vérification de l'email
            $sql = "SELECT * FROM patient WHERE email=?";
            $stm = $pdo->prepare($sql);
            $stm->execute([$email]);
            if ($stm->rowCount() > 0) {
                $msgErreur = "Cette adresse e-mail est déjà utilisée.";
            } else {
                try {
                    // Insertion dans la base de données
                    $insert = $pdo->prepare("INSERT INTO patient (nom, prenom, tel, email, tof, mdp) VALUES (?, ?, ?, ?, ?, ?)");
                    $execute = $insert->execute([$nom, $prenom, $tel, $email, $tofPath, $mdp]);
                    $_SESSION['nom'] = $nom;
                    $_SESSION['tof'] = $tofPath;
                    header("Location: pages/accueil.php");
                    exit();
                } catch (PDOException $e) {
                    $msgErreur = "Erreur: " . $e->getMessage();
                }
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
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Générateur d'Ordonnance</title>
  <style>
      form {
          font-family: Arial, sans-serif;
          margin: 20px;
          padding: 20px;
          border: 1px solid #ccc;
          border-radius: 5px;
          background-color: #f9f9f9;
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
  <h1>Générateur d'Ordonnance</h1>
  <form id="ordonnanceForm">
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
          <input type="text"  name="dosage" id="dosage" required>
      </div>
      <div class="form-group">
          <label for="posologie">Posologie</label>
          <input type="text" name="posologie" id="posologie" required>
      </div>
      <div class="form-group">
          <label for="doctorName">Nom du Médecin</label>
          <input type="text" name="docteur" id="doctorName" required>
      </div>
      <button type="button" onclick="generateOrdonnance()">Générer l'Ordonnance</button>
  </form>
  <div id="ordonnanceOutput" style="margin-top: 20px; display: none;">
      <h2>Ordonnance Générée</h2>
      <div id="ordonnanceContent"></div>
  </div>
  <script>
      function generateOrdonnance() {
          const patientName = document.getElementById('patientName').value;
          const patientDOB = document.getElementById('patientDOB').value;
          const medicament = document.getElementById('medicament').value;
          const dosage = document.getElementById('dosage').value;
          const posologie = document.getElementById('posologie').value;
          const doctorName = document.getElementById('doctorName').value;

          const ordonnanceContent = `
              <p><strong>Nom du Patient :</strong> ${patientName}</p>
              <p><strong>Date de Naissance :</strong> ${patientDOB}</p>
              <p><strong>Médicament :</strong> ${medicament}</p>
              <p><strong>Dosage :</strong> ${dosage}</p>
              <p><strong>Posologie :</strong> ${posologie}</p>
              <p><strong>Nom du Médecin :</strong> ${doctorName}</p>
              <p><strong>Date de l'ordonnance :</strong> ${new Date().toLocaleDateString()}</p>
          `;

          document.getElementById('ordonnanceContent').innerHTML = ordonnanceContent;
          document.getElementById('ordonnanceOutput').style.display = 'block';
      }
  </script>
</body>
</html>
   
</main>

<script src="../../js/all.min.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>
