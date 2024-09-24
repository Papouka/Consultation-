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
$idpatient = $_SESSION['patient'];
require_once("../../inc/connexion.php");

$msgSuccess = '';
$msgErreur = '';


if (isset($_POST['submit'])) {
    $date = $_POST["date"];
    $heure = $_POST["heure"];
    $lien = "https://meet.jit.si/" . uniqid("meeting_"); 
    $iddocteur = $_POST["docteur"];

    // Validation des données
    if (empty($date) || empty($heure) || empty($iddocteur)) {
        $msgErreur = "Tous les champs sont requis.";
    } else {
        try {
            $insert = $pdo->prepare("INSERT INTO video (date, heure, lien, iddocteur) VALUES (?, ?, ?, ?)");
            $execute = $insert->execute([$date, $heure, $lien, $iddocteur]);

            if ($execute) {
                $msgSuccess = "Conférence programmée avec succès.";
            } else {
                $msgErreur = "Échec de la programmation du rendez-vous.";
            }
        } catch (PDOException $e) {
            $msgErreur = "Erreur: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmer un Rendez-vous</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
</head>
<body>
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
<section id="sidebar">
    <?php include("../../inc/sidebar4.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav4.php"); ?>
    </nav>
    <main>
        <form class="form" method="POST">
            <label for="date">Date:</label>
            <div class="form-group"> 
                <input type="date" name="date" required>
            </div>
            <label for="heure">Heure:</label>
            <div class="form-group">
                <input type="time" name="heure" required>
            </div>
            <input type="hidden" name="docteur" value="<?php echo htmlspecialchars($iddocteur); ?>">
            <div class="form-group">
                <button type="submit" name="submit">Programmer un rendez-vous</button>
            </div>
            <?php if ($msgSuccess): ?>
                <div class="form-group">
                    <label for="lien">Lien de la réunion: </label> <a href="$lien"><?php echo htmlspecialchars($lien); ?> </a>
                    
                </div>
            <?php endif; ?>
        </form>
        
        <?php if ($msgErreur): ?>
            <p style="color: red;"><?php echo $msgErreur; ?></p>
        <?php endif; ?>
    </main>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
