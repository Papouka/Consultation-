<?php
session_start();

// Affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$email = $_SESSION['email'] ?? '';
$tof = $_SESSION['tof'] ?? '';
$nom = $_SESSION['nom'] ?? '';
$iddocteur = $_SESSION['docteur'] ?? '';

// Connexion à la base de données
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
if (!isset($_SESSION['docteur'])) {
    echo "ID du médecin non trouvé dans la session.";
    exit();
}

// Inclure PHPMailer
require_once("../../inc/vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Récupérer tous les patients de la base de données
$patientsQuery = $pdo->query("SELECT idpatient, nom, email FROM patient");
$patients = $patientsQuery->fetchAll(PDO::FETCH_ASSOC);

$emailPatient = ""; // Initialiser la variable pour l'email du patient
$message = ""; // Variable pour stocker les messages de retour

// Assurez-vous que $idconsultation est défini, par exemple, depuis une requête ou une session
$idconsultation = $_SESSION['idconsultation'] ?? null; // Remplacez ceci par la logique appropriée

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idpatient'], $_POST['typeexamen']) && !empty($_POST['idpatient']) && isset($_FILES['resultat']) && $_FILES['resultat']['error'] == UPLOAD_ERR_OK) {
        $idpatient = $_POST['idpatient'];
        $typeexamen = $_POST['typeexamen'];
        $resultat = $_FILES['resultat']['name']; // Nom du fichier téléchargé

        // Déplacer le fichier téléchargé vers un dossier spécifique
        $uploadDir = __DIR__ . '/img/';
        $uploadFilePath = $uploadDir . basename($_FILES['resultat']['name']);

        // Vérifiez si le dossier existe, sinon créez-le
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Déplacer le fichier
        if (move_uploaded_file($_FILES['resultat']['tmp_name'], $uploadFilePath)) {
            $stmt = $pdo->prepare("INSERT INTO resultat (idpatient, typeexamen, resultat, dateexamen, statut, `read`, iddocteur, idconsultation) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)");
            $statut = 'Nouveau'; // Exemple de statut
            $read = 0; // 0 pour non lu
            $stmt->execute([$idpatient, $typeexamen, $uploadFilePath, $statut, $read, $iddocteur, $idconsultation]);

            // Récupérer l'email du patient
            $patientQuery = $pdo->prepare("SELECT email FROM patient WHERE idpatient = ?");
            $patientQuery->execute([$idpatient]);
            $patient = $patientQuery->fetch(PDO::FETCH_ASSOC);
            $emailPatient = $patient['email'] ?? ''; 

            // Envoyer l'email avec le fichier en pièce jointe
            $mail = new PHPMailer(true);

            try {
                // Configuration du serveur SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'papoukalory@gmail.com';
                $mail->Password = 'orjqyjacvgvpowxp'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Destinataire
                $mail->setFrom('papoukalory@gmail.com', 'Lory');
                $mail->addAddress($emailPatient); 
                $mail->addReplyTo('papoukalory@gmail.com', 'Lory');

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = "EasyDoctor";
                $mail->Body    = "Bonjour,<br><br>Voici les résultats de vos examens :<br><br>Type d'examen : " . htmlspecialchars($typeexamen) . "<br><br>Téléchargez vos résultats en pièce jointe.";

                // Ajouter le fichier en pièce jointe
                $mail->addAttachment($uploadFilePath);

                // Envoyer l'email
                $mail->send();
                $message = "Résultat enregistré et email envoyé avec succès.";
            } catch (Exception $e) {
                $message = "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        } else {
            $message = "Erreur lors du déplacement du fichier.";
        }
    } else {
        $message = "Patient ou fichier non défini.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer les Résultats d'Examen</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
    <style>
        .form {
            background-color: #f9f9f9; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px; 
            margin: 20px auto; 
        }

        form label {
            display: block; 
            margin-bottom: 8px; 
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="file"],
        form select {
            width: 100%; 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }

        form button {
            background-color: #4CAF50; 
            color: white; 
            padding: 10px 15px; 
            border: none;
            border-radius: 4px; 
            cursor: pointer;
            font-size: 16px; 
        }

        form button:hover {
            background-color: #45a049; 
        }

        .message {
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <section id="sidebar">
        <?php include("../../inc/sidebar2.php"); ?>
    </section>
    <section id="content">
        <nav>
            <?php include("../../inc/nav2.php"); ?>
        </nav>
        <h1>Enregistrer les Résultats d'Examen</h1>
        <?php if ($message): ?>
            <div class="message <?php echo isset($message) && strpos($message, 'Erreur') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" class="form" enctype="multipart/form-data">
            <label for="idpatient">Sélectionner le Patient :</label>
            <select id="idpatient" name="idpatient" required>
                <option value="">-- Sélectionner un patient --</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?php echo htmlspecialchars($patient['idpatient']); ?>"><?php echo htmlspecialchars($patient['nom']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="typeexamen">Type d'Examen :</label>
            <input type="text" id="typeexamen" name="typeexamen" required>

            <label for="resultat">Télécharger les Résultats :</label>
            <input type="file" accept=".pdf,.doc,.docx" class="form-control-file" id="resultat" name="resultat" required>
          
            <button type="submit">Envoyer</button>
        </form>
        <script src="../../js/all.min.js"></script>
        <script src="../../js/chart.js"></script>
        <script src="../../js/script.js"></script>
    </section>
</body>
</html>
