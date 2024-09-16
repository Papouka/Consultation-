<?php
require_once("actions/loginAction.php");
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
                

                <select name="role" id="role" required>
                    <option value="">Sélectionner votre rôle</option>
                    <option value="patient">Patient</option>
                    <option value="docteur">Docteur</option>
                </select><br>
                
                <button type="submit" class="btn">Soumettre</button>
                <div class="register-link">
                    <p>Je n'ai pas de compte <a href="inscription.php">S'inscrire</a></p>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

