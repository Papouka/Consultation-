<?
include("actions/insdocteur.php");
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Multi-Étapes</title>
    <link rel="stylesheet" href="../icons/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="../js/all.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            height: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #343a40;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #495057;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .error-message {
            color: #f44336;
            background-color: #f8d7da;
            padding: 10px;
            border: 1px solid #f44336;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <?php include("inc/header.php"); ?>
    </header>
    <div class="container">
        <form id="multiStepForm" method="POST" enctype="multipart/form-data">
            <div class="step active">
                <h2>Informations Personnelles</h2>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
                
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
              
                <label for="tel">Téléphone:</label>
                <input type="tel" id="tel" name="tel" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="cni">CNI:</label>
                <input type="file" id="cni" name="cni" required>
                
                <label for="tof">Photo de profil:</label>
                <input type="file"  id="tof" name="tof" required>
                
                <label for="idspecialiste">Spécialité:</label>
                <select id="idspecialiste" name="idspecialiste" required>
                    <option value="">Sélectionnez votre spécialité</option>
                    <?php foreach ($specialistes as $specialiste): ?>
                        <option value="<?php echo htmlspecialchars($specialiste['idspecialiste']); ?>">
                            <?php echo htmlspecialchars($specialiste['nomspecialiste']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <label for="grade">Grade:</label>
                <input type="text" id="grade" name="grade" required>
                
                <label for="diplome">Diplome:</label>
                <input type="file" accept=".pdf,.doc,.docx" id="diplome" name="diplome" required>
                
                <label for="certificat">Certificat:</label>
                <input type="file" accept=".pdf,.doc,.docx" id="certificat" name="certificat" required>
                
                <label for="experience">Année d'expérience:</label>
                <input type="number" id="experience" name="experience"  required>
                
                <label for="mdp">Mot de passe:</label>
                <input type="password" id="mdp" name="mdp" required>
                
                <button type="submit" name="submit">Soumettre</button>

                <?php if (!empty($msgErreur)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($msgErreur); ?></div>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <footer>
        <?php include("inc/footer.php"); ?>
    </footer>
    <script src="js/accueil.js"></script>
    <script src="js/all.min.js"></script>
</body>
</html>
