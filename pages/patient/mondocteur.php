<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Préparer et exécuter la requête pour obtenir les informations du médecin
$stmt = $pdo->prepare("
    SELECT * FROM docteur
");
$stmt->execute(); // Exécution sans paramètres
$docteur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$docteur) {
    die("Aucun médecin trouvé.");
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
        body {
            font-family: Arial, sans-serif;
        }
        .doctor-info {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2 {
            margin-bottom: 20px;
        }
        p {
            margin: 10px 0;
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
        <section class="doctor-info">
            <h2>Informations sur mon médecin</h2>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($docteur['nom']); ?></p>
            <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($docteur['idspecialiste']); ?></p>
            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($docteur['tel']); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($docteur['email']); ?></p>
            <p><strong>Grade :</strong> <?php echo htmlspecialchars($docteur['grade']); ?></p>
            <p><strong>Diplôme :</strong> <?php echo htmlspecialchars($docteur['diplome']); ?></p>
            <p><strong>Certificat :</strong> <?php echo htmlspecialchars($docteur['certificat']); ?></p>
        </section>
    </main>

    <script src="../../js/all.min.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
