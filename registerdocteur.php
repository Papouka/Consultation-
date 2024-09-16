<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$msgErreur = ""; // Initialisation de la variable d'erreur

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Traitement du formulaire
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['email'], 
              $_FILES['tof'], $_FILES['cni'], $_POST['idspecialiste'], 
              $_POST['grade'], $_FILES['diplome'], $_FILES['certificat'], 
              $_POST['experience'], $_POST['mdp'])) {
        
        // Vérification des champs requis
        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && 
            !empty($_POST['email']) && !empty($_POST['idspecialiste']) && 
            !empty($_POST['grade']) && !empty($_POST['experience']) && 
            !empty($_POST['mdp'])) {
            
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            $idspecialiste = $_POST["idspecialiste"];
            $grade = $_POST["grade"];
            $experience = $_POST["experience"];
            $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
            
            // Gestion des fichiers
            $cniPath = $tofPath = $diplomePath = $certificatPath = null;

            $uploadErrors = false;

            // Fonction pour gérer le téléchargement des fichiers
            function handleFileUpload($file, &$path) {
                if ($file['error'] == UPLOAD_ERR_OK) {
                    $path = 'img/' . basename($file['name']);
                    return move_uploaded_file($file['tmp_name'], $path);
                }
                return false;
            }

            // Téléchargement des fichiers
            if (!handleFileUpload($_FILES['cni'], $cniPath)) {
                $msgErreur = "Erreur lors du téléchargement de la CNI.";
                $uploadErrors = true;
            }
            if (!handleFileUpload($_FILES['tof'], $tofPath)) {
                $msgErreur = "Erreur lors du téléchargement de la photo de profil.";
                $uploadErrors = true;
            }
            if (!handleFileUpload($_FILES['diplome'], $diplomePath)) {
                $msgErreur = "Erreur lors du téléchargement du diplôme.";
                $uploadErrors = true;
            }
            if (!handleFileUpload($_FILES['certificat'], $certificatPath)) {
                $msgErreur = "Erreur lors du téléchargement du certificat.";
                $uploadErrors = true;
            }

            if ($uploadErrors) {
                $msgErreur .= " Vérifiez les erreurs de téléchargement.";
            } else {
                // Vérification de l'email
                $sql = "SELECT * FROM docteur WHERE email=?";
                $stm = $pdo->prepare($sql);
                $stm->execute([$email]);
                if ($stm->rowCount() > 0) {
                    $msgErreur = "Cette adresse e-mail est déjà utilisée.";
                } else {
                    // Insertion des données dans la base de données
                    try {
                        $insert = $pdo->prepare("INSERT INTO docteur (nom, prenom, tel, email, tof, cni, idspecialiste, grade, diplome, certificat, experience, mdp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $insert->execute([$nom, $prenom, $tel, $email, $tofPath, $cniPath, $idspecialiste, $grade, $diplomePath, $certificatPath, $experience, $mdp]);
                        $_SESSION['nom'] = $nom;
                        $_SESSION['tof'] = $tofPath;
                        header("Location: pages/accueil.php");
                        exit();
                    } catch (PDOException $e) {
                        $msgErreur = "Erreur lors de l'insertion: " . $e->getMessage();
                    }
                }
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}

// Récupération des spécialités
$sql1 = "SELECT * FROM specialiste";
$stm1 = $pdo->prepare($sql1);
$stm1->execute();
$specialistes = $stm1->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
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
            height: auto;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #343a40;
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

        input[type="file"] {
            margin-bottom: 20px;
        }

        button {
            background-color: hsl(158, 97%, 29%);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: green;
            transform: translateY(-2px);
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
            <input type="file" id="tof" name="tof" required>
            
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
            
            <label for="diplome">Diplôme:</label>
            <input type="file" accept=".pdf,.doc,.docx" id="diplome" name="diplome" required>
            
            <label for="certificat">Certificat:</label>
            <input type="file" accept=".pdf,.doc,.docx" id="certificat" name="certificat" required>
            
            <label for="experience">Année d'expérience:</label>
            <input type="number" id="experience" name="experience" required>
            
            <label for="mdp">Mot de passe:</label>
            <input type="password" id="mdp" name="mdp" required>
            
            <button type="submit" name="submit">Soumettre</button>

            <?php if (!empty($msgErreur)): ?>
                <div class="error-message"><?php echo htmlspecialchars($msgErreur); ?></div>
            <?php endif; ?>
        </form>
    </div>
    <footer>
    <?php include("inc/footer.php"); ?>
</footer>
<script src="js/accueil.js"></script>
</body>
</html>
