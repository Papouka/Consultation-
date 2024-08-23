<?php
// Informations de connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=hosto_bd;charset=utf8'; // Remplacez par votre hôte et nom de base de données
$username = 'root'; // Remplacez par votre nom d'utilisateur
$password = ''; // Remplacez par votre mot de passe

try {
    // Créer une nouvelle connexion PDO
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les médecins spécialisés en cardiologie
    // Remplacez '1' par l'ID correct pour la cardiologie si nécessaire
    $stmt = $pdo->prepare("SELECT nom, idspecialiste, tof FROM docteur WHERE idspecialiste = :idspecialiste");
    $stmt->execute(['idspecialiste' => 6]); // Remplacez 1 par l'ID de cardiologie
    $docteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../icons/all.min.css">
    <script src="../js/all.min.js"></script>
    <link rel="stylesheet" href="../css/index.css">
    <title>Document</title>
</head>
<body>
    <style>
        .cont {
            max-width: 3200px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .card {
            width: 50pc;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 10px 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-right: 10px;
        }
        .card h2 {
            margin: 0;
            color: #333;
        }
        .card p {
            margin: 5px 0;
            color: #666;
        }
        .buttons {
            display: flex;
            gap: 10px;
        }
        .button {
            padding: 10px 15px;
            background-color: hsl(158, 97%, 29%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
    
<header>
<?php include("../inc/header.php"); ?>
</header>

<div class="cont">
<h1>Liste des Médecins en Généraliste</h1>
    <?php if (!empty($docteurs)): ?>
        <?php foreach ($docteurs as $docteur): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($docteur['tof']); ?>" alt="<?php echo htmlspecialchars($docteur['nom']); ?>">
                <div>
                    <h2>DR. <?php echo htmlspecialchars($docteur['nom']); ?></h2>
                </div>
                <div class="buttons">
                    <a href=""><button class="button">Détails</button></a>
                    <a href=""><button class="button">Prendre Rendez-vous</button></a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun médecin trouvé en Généraliste.</p>
    <?php endif; ?>
</div>
<footer>
<?php include("../inc/footer.php"); ?>
</footer>

<script src="../js/accueil.js"></script>
</body>
</html>
