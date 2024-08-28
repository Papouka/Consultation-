<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Récupérer l'id du patient à partir de l'email
$stmt = $pdo->prepare("SELECT idpatient, nom FROM patient WHERE email = :email");
$stmt->execute(['email' => $email]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    die("Patient non trouvé.");
}

$idpatient = $patient['idpatient'];
$nomPatient = $patient['nom'];

// Récupérer les dossiermedicals et résultats du patient avec jointures
$stmt = $pdo->prepare(" 
    SELECT * 
    FROM dossiermedical 
    JOIN resultat ON dossiermedical.idpatient = resultat.idpatient 
    WHERE dossiermedical.idpatient = :idpatient 
");
$stmt->bindParam(':idpatient', $idpatient);
$stmt->execute();
$dossiers = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier Médical de <?php echo htmlspecialchars($nomPatient); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        .dossiermedical {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .dossiermedical h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dossier Médical de <?php echo htmlspecialchars($nomPatient); ?></h1>
    </header>
    <main>
        <?php if (count($dossiers) > 0): ?>
            <?php foreach ($dossiers as $dossier): ?>
                <div class="dossiermedical">
                    <p><strong>Diagnostic :</strong> <?php echo htmlspecialchars($dossier['diagnostic']); ?></p>
                    <p><strong>Traitement :</strong> <?php echo htmlspecialchars($dossier['traitement']); ?></p>
                    <p><strong>Type d'examen :</strong> <?php echo htmlspecialchars($dossier['typeexamen']); ?></p>
                    <p><strong>Résultat :</strong> <?php echo nl2br(htmlspecialchars($dossier['resultat'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune dossier médical ou résultat trouvé.</p>
        <?php endif; ?>
    </main>
</body>
</html>
