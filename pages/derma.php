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
    $stmt = $pdo->prepare("SELECT nom, specialite, tof FROM docteur WHERE specialite = :specialite");
    $stmt->execute(['specialite' => 'dermatologie']);
    $docteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Médecins en dermatologie</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .card {
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
            margin-right: 10px; /* Réduit l'espace entre l'image et le nom */
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
            display: flex; /* Change de block à flex pour un meilleur alignement */
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
</head>
<body>
    <div class="container">
        <h1>Liste des Médecins en dermatologie</h1>
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
            <p>Aucun médecin trouvé en dermatologie.</p>
        <?php endif; ?>
    </div>
</body>
</html>
