<?php
session_start();
$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

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

// Inclure PHPMailer
require_once("../../inc/vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Récupérer la liste des patients du médecin
$patients = [];
try {
    $patientsQuery = $pdo->prepare("SELECT * FROM patient WHERE iddocteur = ?");
    $patientsQuery->execute([$_SESSION['iddocteur']]); // Assurez-vous que l'ID du médecin est dans la session
    $patients = $patientsQuery->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des patients : " . $e->getMessage();
}

$emailPatient = ""; // Initialiser la variable pour l'email du patient

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
            // Insérer le résultat dans la base de données
            $stmt = $pdo->prepare("INSERT INTO resultat (idpatient, typeexamen, resultat, dateexamen) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$idpatient, $typeexamen, $uploadFilePath]);

            // Récupérer l'email du patient
            $patientQuery = $pdo->prepare("SELECT email, prenom FROM patient WHERE idpatient = ?");
            $patientQuery->execute([$idpatient]);
            $patient = $patientQuery->fetch(PDO::FETCH_ASSOC);
            $emailPatient = $patient['email']; // Stocker l'email du patient

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
                $mail->addAddress($emailPatient); // Utiliser l'email récupéré
                $mail->addReplyTo('papoukalory@gmail.com', 'Lory');

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = "Résultats de vos examens";
                $mail->Body    = "Bonjour " . htmlspecialchars($patient['prenom']) . ",<br><br>Voici les résultats de vos examens :<br><br>Type d'examen : " . htmlspecialchars($typeexamen) . "<br><br>Téléchargez vos résultats ici : <a href='" . htmlspecialchars($uploadFilePath) . "'>Télécharger</a>";

                // Envoyer l'email
                $mail->send();
                echo "Résultat enregistré et email envoyé.";
            } catch (Exception $e) {
                echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        } else {
            echo "Erreur lors du déplacement du fichier.";
        }
    } else {
        echo "Patient ou fichier non défini.";
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
</head>
<body>
    <style>
       
.form {
    background-color: #f9f9f9; 
    padding: 20px; /* Espacement interne */
    border-radius: 8px; /* Coins arrondis */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Ombre légère */
    max-width: 600px; /* Largeur maximale */
    margin: 20px auto; 
}

/* Style pour les labels */
form label {
    display: block; 
    margin-bottom: 8px; 
    font-weight: bold;
}


form input[type="text"],
form input[type="email"],
form select,
form input[type="file"] {
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

    </style>
<section id="sidebar">
    <?php include("../../inc/sidebar2.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav2.php"); ?>
    </nav>
    <h1>Enregistrer les Résultats d'Examen</h1>
    <form method="POST" action="" class="form" enctype="multipart/form-data">
        <label for="idpatient">Sélectionner le Patient :</label>
        <select id="idpatient" name="idpatient" required onchange="updateEmail()">
            <option value="">--Sélectionner un patient--</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?php echo htmlspecialchars($patient['idpatient']); ?>">
                    <?php echo htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']); ?>
                </option>
            <?php endforeach; ?>
        </select>

     
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($emailPatient); ?>" hidden>

        <label for="typeexamen">Type d'Examen :</label>
        <input type="text" id="typeexamen" name="typeexamen" required>

        <label for="resultat">Télécharger les Résultats :</label>
        <input type="file" accept=".pdf,.doc,.docx" class="form-control-file" id="resultat" name="resultat" required>
      
        <button type="submit">Envoyer</button>
    </form>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/chart.js"></script>
    <script src="../../js/script.js"></script>
    <script>
        // Fonction pour mettre à jour l'email du patient sélectionné
        function updateEmail() {
            const select = document.getElementById('idpatient');
            const emailInput = document.getElementById('email');
            const selectedOption = select.options[select.selectedIndex];

            // Récupérer l'email du patient sélectionné
            const email = selectedOption.getAttribute('data-email');
            emailInput.value = email || '';
        }
    </script>
</body>
</html>
