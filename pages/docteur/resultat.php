<?php
session_start();

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

// Inclure PHPMailer
require ("PHPMailer-master/src/Exception.php");
require ("PHPMailer-master/src/PHPMailer.php");
require ("PHPMailer-master/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si les champs nécessaires sont définis
    if (isset($_POST['idpatient']) && !empty($_POST['idpatient'])) {
        $idpatient = $_POST['idpatient'];
        $typeexamen = $_POST['typeexamen'];
        $resultat = $_POST['resultat'];

        // Insérer le résultat dans la base de données
        $stmt = $pdo->prepare("INSERT INTO resultat (idpatient, typeexamen, resultat, dateexamen) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$idpatient, $typeexamen, $resultat]);

        // Récupérer les informations du patient
        $patientQuery = $pdo->prepare("SELECT * FROM patient WHERE idpatient = ?");
        $patientQuery->execute([$idpatient]);
        $patient = $patientQuery->fetch(PDO::FETCH_ASSOC);

        if ($patient) { // Vérifiez si le patient existe
            $mail = new PHPMailer(true);

            try {
                // Configuration du serveur SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.example.com'; // Remplacez par votre serveur SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'your_email@example.com'; // Votre adresse email
                $mail->Password = 'your_password'; // Votre mot de passe
                $mail->SMTPSecure = 'tls'; // ou 'ssl' selon la configuration de votre serveur SMTP
                $mail->Port = 587; // ou 465 pour SSL

                // Destinataire
                $mail->setFrom('your_email@example.com', 'Votre Nom');
                $mail->addAddress($patient['email']); // L'email du patient

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = "Résultats de vos examens";
                $mail->Body    = "Bonjour " . htmlspecialchars($patient['prenom']) . ",<br><br>Voici les résultats de vos examens :<br><br>" . nl2br(htmlspecialchars($resultat));

                // Envoyer l'email
                $mail->send();
                echo "Résultat enregistré et email envoyé.";
            } catch (Exception $e) {
                echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        } else {
            echo "Patient non trouvé.";
        }
    } else {
        echo "ID du patient non défini.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer les Résultats d'Examen</title>
</head>
<body>
    <h1>Enregistrer les Résultats d'Examen</h1>
    <form method="POST" action="">
        <label for="idpatient">ID du Patient :</label>
        <input type="number" id="idpatient" name="idpatient" required>

        <label for="typeexamen">Type d'Examen :</label>
        <input type="text" id="typeexamen" name="typeexamen" required>

        <label for="resultat">Résultat :</label>
        <textarea id="resultat" name="resultat" required></textarea>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
