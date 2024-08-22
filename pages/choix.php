<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Requête SQL pour récupérer les docteurs
try {
    $query = "SELECT * FROM docteur";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $docteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des docteurs : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir un Docteur</title>
    <link rel="stylesheet" href="../css/patient.css">
    <style>
        ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap; 
            justify-content: center;
        }

        li {
            margin: 10px; 
            flex: 1 1 calc(25% - 20px); 
            box-sizing: border-box;
        }

        .card {
            width: 100%; 
            max-width: 300px; 
            padding: 20px;
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
        }

        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .buttons {
            margin-top: 10px;
        }

        .button {
            padding: 10px 15px;
            margin: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <!-- Inclure ici votre code de header -->
</header>

<h1>Choisissez votre Docteur</h1>

<form method="POST" action="#">
    <ul>
        <?php foreach ($docteurs as $doc): ?>
            <li>
                <div class="card">
                    <img src="../<?php echo htmlspecialchars($doc['tof']); ?>" alt="<?php echo htmlspecialchars($doc['nom']); ?>">
                    <h2>DR. <?php echo htmlspecialchars($doc['nom']); ?></h2>
                    <p><strong>Prénom:</strong> <?php echo htmlspecialchars($doc['prenom']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($doc['email']); ?></p>
                    <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($doc['tel']); ?></p>
                    <div class="buttons">
                        <input type="radio" name="id_docteur" value="<?php echo htmlspecialchars($doc['iddocteur']); ?>" id="doc<?php echo htmlspecialchars($doc['iddocteur']); ?>" required>
                        <label for="doc<?php echo htmlspecialchars($doc['iddocteur']); ?>">Sélectionner</label>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="../pages/patient/rendezvous.php"><button type="submit" class="button">Prendre Rendez-vous</button></a>
</form>

<footer>
    <!-- Inclure ici votre code de footer -->
</footer>

</body>
</html>
