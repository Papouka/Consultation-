<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

// Récupérer les informations du docteur
$docteurInfo = [];
if (isset($_GET['iddocteur'])) {
    $docteurInfo['iddocteur'] = $_GET['iddocteur'];
    $docteurInfo['nom'] = $_GET['nom'] ?? '';
    $docteurInfo['prenom'] = $_GET['prenom'] ?? '';
    $docteurInfo['email'] = $_GET['email'] ?? '';
    $docteurInfo['tel'] = $_GET['tel'] ?? '';
}



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
    if (isset($_POST['nompat'], $_POST['prenompat'], $_POST['emailpat'], $_POST['telpat'], $_POST['date'], $_POST['heure'])) {
        if (!empty($_POST['nompat']) && !empty($_POST['prenompat']) && !empty($_POST['emailpat']) && !empty($_POST['telpat']) && !empty($_POST['date']) && !empty($_POST['heure'])) {
            $nompat = $_POST["nompat"];
            $prenompat = $_POST["prenompat"];
            $emailpat = $_POST["emailpat"];
            $telpat = $_POST["telpat"];
            $date = $_POST["date"];
            $heure = $_POST["heure"];
        
            try {
                // Insertion dans la base de données
                $insert = $pdo->prepare("INSERT INTO rendezvous (nompat, prenompat, emailpat, telpat, date, heure) VALUES (?, ?, ?, ?, ?, ?)");
                $execute = $insert->execute([$nompat, $prenompat, $emailpat, $telpat, $date, $heure]);

                // Si l'insertion est réussie
                if ($execute) {
                    $msgSuccess = "Rendez-vous programmé avec succès.";
                    // Optionnel : redirection après succès
                    // header("Location: confirmation.php"); // Redirigez vers une page de confirmation
                    // exit();
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

            <?php if ($msgSuccess): ?>
                <div style="color: green;"><?php echo $msgSuccess; ?></div>
            <?php endif; ?>
            <?php if ($msgErreur): ?>
                <div style="color: red;"><?php echo $msgErreur; ?></div>
            <?php endif; ?>

            <div class="form-group"><label for="nom">Nom:</label>
            <input type="text" id="nom" name="nompat" required>
            </div>
            <div class="form-group"><label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenompat" required>
            </div>
            <div class="form-group"> <label for="email">Email:</label>
            <input type="email" id="email" name="emailpat" required>
            </div>
            <div class="form-group"> <label for="telephone">Téléphone:</label>
            <input type="tel" id="telephone" name="telpat" required>
            </div>
            <div class="form-group"> <label for="date">Date de Rendez-vous:</label>
            <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group"> <label for="heure">Heure de Rendez-vous:</label>
            <input type="time" id="heure" name="heure" required><br><br>
            </div>
            <button type="submit" name="submit">Programmer le Rendez-vous</button>
        </form>
    </section>
</main>

<script src="../../js/all.min.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>
