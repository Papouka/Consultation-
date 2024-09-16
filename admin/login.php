<?php
session_start();
$error = "";

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
        $sql = "SELECT * FROM administrateur WHERE email=?";
    
    $stm = $pdo->prepare($sql);
    try {
        $stm->execute([$email]); 
    } catch (PDOException $e) {
        die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
    }

    if ($stm->rowCount() > 0) {
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        // Vérification du mot de passe
        
            $_SESSION['email'] = $email;
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['tof'] = $row['tof'];
            header("Location: ../admin/index.php");
            exit();
        
    } else {
    
        $error = "Adresse mail ou mot de passe incorrecte";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),url(img/30.jpg);
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff; 
        }
        
        .wrapper {
            background: transparent; 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px hsl(158, 97%, 29%);
            width: 350px;
            text-align: center;
        }
        
        h1 {
            margin-bottom: 20px;
            color: white; 
        }
        
        .container {
            display: flex;
            flex-direction: column;
        }
       
        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: black; 
        }
        
        input[type="email"],
        input[type="password"],
        select {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        select {
            cursor: pointer;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: hsl(158, 97%, 29%);
            box-shadow: 0 0 5px rgba(38, 198, 218, 0.5);
            outline: none;
        }
       
        .btn {
            background-color: hsl(158, 97%, 29%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            font-weight: bold;
        }
        .btn:hover {
            background-color: hsl(158, 97%, 39%);
            transform: translateY(-2px); 
        }
        p{
            color: white;
        }
        .register-link {
            margin-top: 15px;
            font-size: 0.9em; 
        }
        
        .register-link a {
            color: hsl(158, 97%, 29%);
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Connexion</h1>
            <div class="container">
                <?php if ($error): ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <input type="email" name="email" id="email" placeholder="Entre votre Email" required>
                
                
                <input type="password" name="mdp" id="mdp" placeholder="Entre votre mot de passe" required>
                
                
                <button type="submit" class="btn">Soumettre</button>
            </div>
        </form>
    </div>
</body>
</html>

