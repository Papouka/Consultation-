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
    $stmt->execute(['specialite' => 'Cardiologie']);
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
    <title>Liste des Médecins en Cardiologie</title>
    <link rel="stylesheet" href="../icons/all.min.css">
    <script src="../js/all.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        nav {
    margin: 20px 0;
}
nav a {
    margin: 0 15px;
    color: rgb(0, 0, 0);
    text-decoration: none;
}

.lien {
    background: hsl(158, 97%, 29%);
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
}

.logo {
    color: black;
    font-weight: 700;
    font-size: 1.4rem;
    text-decoration: none;
}

.logo span {
    background-color: hsl(158, 97%, 29%);
    color: aliceblue;
    padding: 0px 5px;
    border-radius: 5px;
    font-weight: 600;
    margin-right: 5px;
}

.navbar {
    list-style: none;
    display: flex;
    gap: 15px;
}

.navbar a {
    text-decoration: none;
    color: #333;
}

.main {
    display: flex;
    align-items: center;
    gap: 15px;
}

.main a {
    text-decoration: none;
    color: #333;
}

.user {
    font-size: 20px;
    text-decoration: none;
    color: #333;
}

ul {
    list-style-type: none; /* Supprime les puces */
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
}

.navbar {
    list-style: none;
    display: flex;
}

.navbar li {
    margin: 0 10px;
}

.menu-toggle {
    display: none;
    cursor: pointer;
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
        

footer {
    display: flex;
    background-color: hsl(158, 97%, 39%);
    color: white;
    text-align: center;
    padding: 8px 0;
    margin-top: 5em;
    position: relative;
    bottom: 0;
    width: 100%;
}

footer p {
    margin: 0;
    font-size: small;
    color: #ffffff;
}
/* Styles pour les écrans plus petits */
@media (max-width: 768px) {
    .navbar {
        display: none;
        flex-direction: column;
        position: absolute;
        background-color: white;
        top: 50px;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    .navbar.active {
        display: flex;
    }

    .menu-toggle {
        display: block;
    }

    nav {
        display: flex;
        flex-direction: column;
    }

    nav a {
        margin: 10px 0;
    }

    .step, .ste {
        flex: 1 1 100%; /* Prend toute la largeur sur petits écrans */
        margin: 10px 0; /* Ajoute un espacement */
    }

    .hero h1 {
        font-size: 2em; /* Ajustement de la taille pour petits écrans */
    }

    .hero p {
        font-size: 1em; /* Ajustement de la taille pour petits écrans */
    }
}

@media (max-width: 480px) {
    .hero h2 {
        font-size: 1.5em;
    }

    .hero p {
        font-size: 0.9em;
    }

    .step img, .ste img {
        width: 150px; /* Ajuste la taille de l'image */
        height: 150px;
    }
}

    </style>
</head>
<body>
<header>
<?php include("../inc/header.php"); ?>
    </header>
    <div class="container">
        <h1>Liste des Médecins en Cardiologie</h1>
        <?php if (!empty($docteurs)): ?>
            <?php foreach ($docteurs as $docteur): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($docteur['tof']); ?>" alt="<?php echo htmlspecialchars($docteur['nom']); ?>">
                    <div>
                        <h2>DR. <?php echo htmlspecialchars($docteur['nom']); ?></h2>
                        
                    </div>
                    <div class="buttons">
                       <a href=""> <button class="button">Détails</button></a>
                       <a href=""> <button class="button">Prendre Rendez-vous</button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun médecin trouvé en cardiologie.</p>
        <?php endif; ?>
    </div>
    <footer>
<?php include("../inc/footer.php"); ?>
    </footer>
    <script src="../js/accueil.js"></script>
</body>
</html>
