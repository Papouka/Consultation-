<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


$docteur = [];
if (isset($_GET['idspecialiste'])) {
    $idspecialiste = $_GET['idspecialiste'];

    // Préparez et exécutez la requête pour récupérer les docteurs
    try {
        $stmt = $pdo->prepare("SELECT * FROM docteur WHERE idspecialiste = :idspecialiste");
        $stmt->bindParam(':idspecialiste', $idspecialiste, PDO::PARAM_INT);
        $stmt->execute();
        $docteur = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des docteurs : " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Docteurs</title>
    <link rel="stylesheet" href="../icons/all.min.css">
    <script src="../js/all.min.js"></script>
    <link rel="stylesheet" href="../css/patient.css">
    <link rel="stylesheet" href="../css/index.css">
    <?php include("../inc/cssspecialiste.php"); ?>
</head>
<body>
<header>
<?php include("../inc/header.php"); ?>
    </header>
<h2>Liste des docteurs spécialisés</h2>
<?php if (!empty($docteur)): ?>
    <ul>
        <?php foreach ($docteur as $doc): ?>
            <li>
            <div class="card">
                <img src="../<?php echo htmlspecialchars($doc['tof']); ?>" alt="<?php echo htmlspecialchars($doc['nom']); ?>">
                <div>
                    <h2>DR. <?php echo htmlspecialchars($doc['nom']); ?></h2>
                </div>
                <div class="buttons">
                    <a href=""><button class="button">Détails</button></a>
                    <a href=""><button class="button">Prendre Rendez-vous</button></a>
                </div>
            </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun docteur trouvé pour cette spécialité.</p>
<?php endif; ?>

<footer>
<?php include("../inc/footer.php"); ?>
</footer>
<script src="../js/accueil.js"></script>
</body>
</html>
