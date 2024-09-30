<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof'];
$nom = $_SESSION['nom'];
$iddocteur = $_SESSION['docteur'];
require_once("../../inc/connexion.php");
require_once("../../inc/vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$msgSuccess = '';
$msgErreur = '';

// Récupérer la liste des patients
$patients = [];
try {
    $query = $pdo->query("SELECT idpatient, nom, email FROM patient"); 
    $patients = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $msgErreur = "Erreur lors de la récupération des patients : " . htmlspecialchars($e->getMessage());
}

if (isset($_POST['submit'])) {
    $date = $_POST["date"];
    $heure = $_POST["heure"];
    $lien = "https://meet.jit.si/" . uniqid("meeting_"); 
    $iddocteur = $_POST["docteur"];
    $idpatient = $_POST["patient"]; 

    // Validation des données
    if (empty($date) || empty($heure) || empty($iddocteur) || empty($idpatient)) {
        $msgErreur = "Tous les champs sont requis.";
    } else {
        try {
            // Récupérer l'email du patient
            $query = $pdo->prepare("SELECT email, nom FROM patient WHERE idpatient = ?");
            $query->execute([$idpatient]);
            $patient = $query->fetch(PDO::FETCH_ASSOC);

            
            $queryDocteur = $pdo->prepare("SELECT email, nom FROM docteur WHERE iddocteur = ?");
            $queryDocteur->execute([$iddocteur]);
            $docteur = $queryDocteur->fetch(PDO::FETCH_ASSOC);

            if ($patient && $docteur) {
                
                $insert = $pdo->prepare("INSERT INTO video (date, heure, lien, iddocteur, idpatient) VALUES (?, ?, ?, ?, ?)");
                $execute = $insert->execute([$date, $heure, $lien, $iddocteur, $idpatient]);

                if ($execute) {
                   
                   

                    $mail = new PHPMailer(true); 
                    try {
                        
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'papoukalory@gmail.com'; 
                        $mail->Password = 'orjqyjacvgvpowxp';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        // Destinataires
                        $mail->setFrom('papoukalory@gmail.com', 'Lory');
                        $mail->addAddress($patient['email'], $patient['nom']); 

                       
                        $mail->isHTML(true);
                        $mail->Subject = 'Lien de la videoconference';
                        $mail->Body = "Bonjour,<br><br>Voici le lien pour votre vidéoconférence : <a href='localhost/easydoctor/pages/conference.php?lien=$lien'>192.168.8.115/easydoctor/pages/conference.php?$lien</a><br><br> qui est prévu pour le $date à $heure";

                        $mail->send();
                        $msgSuccess = "Conférence programmée avec succès et email envoyé au patient.";
                    } catch (Exception $e) {
                        $msgErreur = "Échec de l'envoi de l'email. Erreur: {$mail->ErrorInfo}";
                    }
                } else {
                    $msgErreur = "Échec de la programmation du rendez-vous.";
                }
            } else {
                $msgErreur = "Patient ou docteur non trouvé.";
            }
        } catch (PDOException $e) {
            $msgErreur = "Erreur: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmer un Rendez-vous</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
</head>
<body>
    <style>
        .form {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
<section id="sidebar">
    <?php include("../../inc/sidebar4.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav4.php"); ?>
    </nav>
    <main>
        <form class="form" method="POST">
            <label for="date">Date:</label>
            <div class="form-group"> 
                <input type="date" name="date" required>
            </div>
            <label for="heure">Heure:</label>
            <div class="form-group">
                <input type="time" name="heure" required>
            </div>
            <div class="form-group">
                <label for="patient">Sélectionner un patient:</label>
                <select name="patient" required>
                    <option value="">-- Choisir un patient --</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo htmlspecialchars($patient['idpatient']); ?>">
                            <?php echo htmlspecialchars($patient['nom']); ?> (<?php echo htmlspecialchars($patient['email']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="docteur" value="<?php echo htmlspecialchars($iddocteur); ?>">
            <div class="form-group">
                <button type="submit" name="submit">Programmer un rendez-vous</button>
            </div>
            <?php if ($msgSuccess): ?>
                <div class="form-group">
                    <label for="lien">Lien de la réunion: </label> <a href="<?php echo htmlspecialchars($lien); ?>"><?php echo htmlspecialchars($lien); ?></a>
                </div>
            <?php endif; ?>
        </form>
        
        <?php if ($msgErreur): ?>
            <p style="color: red;"><?php echo $msgErreur; ?></p>
        <?php endif; ?>
    </main>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
