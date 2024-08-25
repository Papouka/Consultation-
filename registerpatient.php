<?
    include("actions/inspatient.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, in itial-scale=1.0">
    <link rel="stylesheet" href="icons/all.min.css">
    <script src="js/all.min.js"></script>
    <link rel="stylesheet" href="css/patient.css">
    <link rel="stylesheet" href="css/index.css">
    
    <title>Document</title>
    
</head>
<style>
   
.site {
  font-family: Arial, sans-serif;
  background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),url(img/30.jpg);
            background-size: cover;
            background-position: center;
}

.contain {
  max-width: 800px;
  margin: 40px auto;
  padding: 20px;
 
}

.form-box {
    margin-top: 10%;
  width: 100%;
  padding: 20px;
}

.form {
    width: 40pc;
    background: white; 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px hsl(158, 97%, 29%);
            text-align: center;
}

.form > div {
  margin-bottom: 20px;
}

.form input[type="text"],
.form input[type="tel"],
.form input[type="email"],
.form input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
}

.form label {
  margin-bottom: 10px;
  color: white;
}

.btn-group {
  text-align: center;
}

.btn-submit {
  background-color: #4CAF50;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn-submit:hover {
  background-color: #3e8e41;
}

.error-message {
  color: red;
  margin-bottom: 20px;
}


</style>
<body>
    
<header>
<?php include("inc/header.php"); ?>
    </header>

    <div id="page" class="site">
        <div class="contain">
            <div class="form-box">
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form one form-step active">
                        <h2>Entrer vos informations personnelles</h2>
                        <div>
                            
                            <input type="text" name="nom" placeholder="Votre nom" required>
                        </div> 
                        <div>
                            
                            <input type="text" name="prenom" placeholder="Votre prénom" required>
                        </div>
                        <div>
                            
                            <input type="tel" name="tel" placeholder="Votre numéro de téléphone" required>
                        </div>
                        <div>
                        
                            <input type="email" name="email" placeholder="Votre email" required>
                        </div>
                        
                        <div>
                            
                            <input type="password" name="mdp" placeholder="Votre mot de passe" required>
                        </div>
                        <div>
                            <label>Votre photo de profil</label>
                            <input type="file" id="imageUpload" name="tof" accept="image/*" required>
                        
                       
                    </div>

                    <div class="btn-group">
                        
                       <a href="pages/symptome.php"> <button type="submit" name="submit" class="btn-submit" >ENVOYER</button> </a>
                    </div>
                </form>
                
                <?php if ($msgErreur): ?>
                    <div class="error-message"><?php echo $msgErreur; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<script src="js/accueil.js"></script>
