<?php
session_start();

require_once("inc/connexion.php");

// Maintenant, vous pouvez utiliser $pdo pour préparer vos requêtes
$stmt = $pdo->prepare("SELECT * FROM specialiste");
$stmt->execute();
$specialiste = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, in itial-scale=1.0">
    <link rel="stylesheet" href="icons/all.min.css">
    <script src="js/all.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
    
</head>
<body>
    
<header>
<?php include("inc/header.php"); ?>
    </header>


<div class="container">
    <div class="hero"><br><br><br><br>
        <h2>Consultez un médecin en ligne</h2>
        <p>Accédez à des consultations médicales depuis le confort de votre maison.</p><br>
        <?php
if (isset($_SESSION['email'])) {
   
    echo '<a href="pages/symptome.php" class="lien">Consultez-vous maintenant</a><br><br>';
} else {
   
    echo '<a href="registerpatient.php" class="lien">Consultez-vous maintenant</a><br><br>';
}
?>


        
    </div>
</div>
<h1>Nos services</h1>
<div class="contain">
    
<div class="step">
    
            <img src="img/11.jpg" alt="Questionnaire Médical"> 
            <h2>1. Consultaion video</h2>
            <p>Après avoir précisé la nature de vos symptômes lors d’un questionnaire précédant le diagnostic, Feeli vous oriente immédiatement vers un spécialiste de santé. Sans RDV et en quelques minutes, la téléconsultation débute via une messagerie instantanée, le tout offrant une</p>
            </div>
        <div class="step">
            <img src="img/14.jpg" alt="Consultation et diagnostic"> 
            <h2>2. Conseils médicaux</h2>
            <p>À l’aide des réponses au questionnaire, le médecin peut débuter la téléconsultation par messagerie instantanée. Si nécessaire un traitement pourra vous être proposé. Le montant de la téléconsultation est supporté entièrement par le patient.</p>
            
        </div>
        <div class="step">
            <img src="img/17.jpg" alt="Délivrance de votre remède"> 
            <h2>3. Prescription électronique</h2>
            <p>En fonction du diagnostic et si un remède est nécessaire, le médecin pourra établir un document médical valable en pharmacie, directement accessible depuis votre espace personnel. Si besoin, le médecin pourra compléter votre document médical par des examens</p>
            
        </div>
        <div class="step">
            <img src="img/17.jpg" alt="Délivrance de votre remède"> 
            <h2>4. Suivi de santé personnalisé</h2>
            <p>En fonction du diagnostic et si un remède est nécessaire, le médecin pourra établir un document médical valable en pharmacie, directement accessible depuis votre espace personnel. Si besoin, le médecin pourra compléter votre document médical par des examens</p>
            
        </div>
        </div>
<div class="containe">
        <h1>À propos de Easydoctor</h1>
    <h2>Service de médecins à distance</h2> <br>
    <div class="stats">
        <div class="stat">
            <img src="https://image-url.com/icon1.png" alt="Patients">
            <p>500.000 patients<br>nous font confiance</p>
        </div>
        <div class="stat">
            <img src="https://image-url.com/icon2.png" alt="Consultations">
            <p>92% des consultations<br>traitées</p>
        </div>
        <div class="stat">
            <img src="https://image-url.com/icon3.png" alt="Temps d'attente">
            <p>Temps d'attente moyen<br>constaté < 30 minutes</p>
        </div>
    </div>
    </div>

    <div class="contai">
    <div class="hero"><br><br>
        <h2 >Vous etes médécin?</h2>
       
        <a href="registerdocteur.php" class="lory" >Rejoignez nous</a><br><br>
    </div><br><br><br><br>
    <h1>Nos engagements</h1>
    <div class="cont">
    
<div class="ste">
            <img src="img/15.jpg" alt="Questionnaire Médical"> 
            <h2>Service d'information</h2>
            <p>Un service client est à votre écoute 7 jours sur 7.</p>
            </div>
        <div class="ste">
            <img src="img/21.jpg" alt="Consultation et diagnostic"> 
            <h2>Données sécurisées et cryptées</h2>
            <p>Vous êtes propriétaire de vos données
            de santé</p>
            
        </div>
        <div class="ste">
            <img src="img/25.avif" alt="Délivrance de votre remède"> 
            <h2>Votre remède en ligne</h2>
            <p>Disponible sous format numérique après la téléconsultation dans votre espace sécurisé Easydoctor</p>
            
        </div>
        </div>
<footer>
<?php include("inc/footer.php"); ?>
</footer>


    <script src="js/accueil.js"></script>
</body>
</html>