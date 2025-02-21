<?php
session_start();
require_once("../../inc/vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
$iddoct = $_SESSION['docteur']; 

if (isset($_GET['action']) && isset($_GET['id'])) {
    $idRendezvous = $_GET['id'];
    $action = $_GET['action'];

   
    if ($action === 'accepter') {
        $update = $pdo->prepare("UPDATE consultation SET statut = 'accepté' WHERE idconsultation = ?");
        $update->execute([$idRendezvous]);

       
        $stmt = $pdo->prepare("SELECT patient.email, patient.nom FROM consultation JOIN patient ON consultation.idpatient = patient.idpatient WHERE consultation.idconsultation = ?");
        $stmt->execute([$idRendezvous]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($patient) {
            // Préparer l'email pour le patient avec PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'papoukalory@gmail.com';
                $mail->Password = 'orjqyjacvgvpowxp'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Destinataire
                $mail->setFrom('papoukalory@gmail.com', 'Lory'); // Remplacez par l'email de l'expéditeur
                $mail->addAddress($patient['email']); // Ajoutez l'adresse email du patient

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = "Confirmation de votre rendez-vous";
                $mail->Body = "Bonjour " . htmlspecialchars($patient['nom']) . ",<br><br>" .
                              "Votre demande de rendez-vous a été acceptée par le docteur.<br>" . "le Coût s'élève à " .
                              "Merci de votre confiance.";

                $mail->send();
            } catch (Exception $e) {
                echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        }

        echo "<script>alert('Rendez-vous accepté.'); window.location.href='pages/docteur/priserendezvous.php';</script>";
    } elseif ($action === 'refuser') {
        $update = $pdo->prepare("UPDATE consultation SET statut = 'refusé' WHERE idconsultation = ?");
        $update->execute([$idRendezvous]);

       
        $stmt = $pdo->prepare("SELECT patient.email, patient.nom FROM consultation JOIN patient ON consultation.idpatient = patient.idpatient WHERE consultation.idconsultation = ?");
        $stmt->execute([$idRendezvous]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($patient) {
          
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'papoukalory@gmail.com';
                $mail->Password = 'orjqyjacvgvpowxp'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Destinataire
                $mail->setFrom('papoukalory@gmail.com', 'Lory'); 
                $mail->addAddress($patient['email']); 

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = "Refus de votre rendez-vous";
                $mail->Body = "Bonjour " . htmlspecialchars($patient['nom']) . ",<br><br>" .
                              "Votre demande de rendez-vous a été refusée par le docteur.<br>" .
                              "Merci de votre compréhension.";

                $mail->send();
            } catch (Exception $e) {
                echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        }

        echo "<script>alert('Rendez-vous refusé.'); window.location.href='pages/docteur/priserendezvous.php';</script>";
    }
}

// Récupérer la liste des rendez-vous pour le médecin
$stmt = $pdo->prepare("
    SELECT DISTINCT c.dateconsultation, p.nom, p.prenom, c.idconsultation
    FROM consultation c
    JOIN patient p ON c.idpatient = p.idpatient
    WHERE c.iddocteur = ?
");
$stmt->execute([$iddoct]);
$rendezvous = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Rendez-vous</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
</head>
<style>
.container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f4f4f4;
}
h1 {
    text-align: center;
   
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
th {
    background-color: green;
    color: white;
}
</style>
<body>
<section id="sidebar">
    <?php include("../../inc/sidebar2.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav2.php"); ?>
    </nav>
    <h1>Liste de vos Rendez-vous</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Patient</th>
                <th>Actions</th> <!-- Nouvelle colonne pour les actions -->
            </tr>
        </thead>
        <tbody>
            <?php if (count($rendezvous) > 0): ?>
                <?php foreach ($rendezvous as $rdv): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($rdv['dateconsultation']))); ?></td>
                        <td><?php echo htmlspecialchars(date('H:i', strtotime($rdv['dateconsultation']))); ?></td>
                        <td><?php echo htmlspecialchars($rdv['prenom'] . ' ' . $rdv['nom']); ?></td>
                        <td>
                            <a href="?action=accepter&id=<?php echo $rdv['idconsultation']; ?>">Accepter</a>
                            <a href="?action=refuser&id=<?php echo $rdv['idconsultation']; ?>">Refuser</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucun rendez-vous trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/chart.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
