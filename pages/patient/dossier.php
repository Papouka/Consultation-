<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Récupérer l'id et les informations du patient à partir de l'email
$stmt = $pdo->prepare("SELECT idpatient, nom, prenom, tel, email FROM patient WHERE email = :email");
$stmt->execute(['email' => $email]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    die("Patient non trouvé.");
}

$idpatient = $patient['idpatient'];
$nomPatient = $patient['nom'];
$prenomPatient = $patient['prenom'];
$telephonePatient = $patient['tel'];
$emailPatient = $patient['email'];

// Récupérer les dossiers médicaux et les informations du docteur
$stmt = $pdo->prepare("
    SELECT c.diagnostic, c.traitement, c.typeexamen, d.nom AS nom_docteur, d.prenom AS prenom_docteur, d.idspecialiste, d.email,d.tel ,r.resultat FROM consultation c JOIN docteur d ON c.iddocteur = d.iddocteur
     JOIN specialiste s ON d.idspecialiste = s.idspecialiste LEFT JOIN resultat r ON c.idconsultation = r.idconsultation;
    WHERE c.idpatient = :idpatient
");
$stmt->execute(['idpatient' => $idpatient]);
$dossiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si la demande de téléchargement PDF est faite
if (isset($_GET['download'])) {
    require_once("../../inc/dompdf/autoload.inc.php");
    // Assurez-vous que le chemin est correct
                       $dompdf = new Dompdf\Dompdf();
    // Créer le contenu HTML
    $html = '<h1>Dossier Médical</h1>';
    $html .= '<h3>Informations Personnelles</h3>';
    $html .= '<p><strong>Nom :</strong> ' . htmlspecialchars($nomPatient) . '</p>';
    $html .= '<p><strong>Prénom :</strong> ' . htmlspecialchars($prenomPatient) . '</p>';
    $html .= '<p><strong>Téléphone :</strong> ' . htmlspecialchars($telephonePatient) . '</p>'; 
    $html .= '<p><strong>Email :</strong> ' . htmlspecialchars($emailPatient) . '</p>';
    $html .= '<h3>Historique des Consultations</h3>';

    if (count($dossiers) > 0) {
        foreach ($dossiers as $dossier) {
            $html .= '<div>';
            $html .= '<p><strong>Type d\'examen :</strong> ' . htmlspecialchars($dossier['typeexamen']) . '</p>';
            $html .= '<p><strong>Diagnostic :</strong> ' . htmlspecialchars($dossier['diagnostic']) . '</p>';
            $html .= '<p><strong>Traitement :</strong> ' . htmlspecialchars($dossier['traitement']) . '</p>';
            $html .= '<p><strong>Docteur :</strong> ' . htmlspecialchars($dossier['prenom_docteur'] . ' ' . $dossier['nom_docteur']) . '</p>';
            $html .= '<p><strong>Specialité :</strong> ' . htmlspecialchars($dossier['idspecialiste']) . '</p>';
            $html .= '<p><strong>Email :</strong> ' . htmlspecialchars($dossier['email']) . '</p>';
            $html .= '<p><strong>Téléphone:</strong> ' . htmlspecialchars($dossier['tel']) . '</p>';
            $html .= '</div><hr>';
        }
    } else {
        $html .= '<p>Aucun dossier médical ou résultat trouvé.</p>';
    }

    // Charger le contenu HTML dans Dompdf
    $dompdf->loadHtml($html);

    // (Optionnel) Configurer la taille et l'orientation du papier
    $dompdf->setPaper('A4', 'portrait');

    // Rendre le HTML en PDF
    $dompdf->render();

    // Envoyer le PDF au navigateur
    $dompdf->stream('dossier_medical.pdf', ['Attachment' => true]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier Médical de <?php echo htmlspecialchars($nomPatient . ' ' . $prenomPatient); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        .dossiermedical {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .dossiermedical h3 {
            margin-top: 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dossier Médical de <?php echo htmlspecialchars($nomPatient . ' ' . $prenomPatient); ?></h1>
    </header>
    <main>
        <h3>Informations Personnelles</h3>
        <p><strong>Nom :</strong> <?php echo htmlspecialchars($nomPatient); ?></p>
        <p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenomPatient); ?></p>
        <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($telephonePatient); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($emailPatient); ?></p>

        <h3>Historique des Consultations</h3>
        <?php if (count($dossiers) > 0): ?>
            <?php foreach ($dossiers as $dossier): ?>
                <div class="dossiermedical">
                    <p><strong>Type d'examen :</strong> <?php echo htmlspecialchars($dossier['typeexamen']); ?></p>
                    <p><strong>Diagnostic :</strong> <?php echo htmlspecialchars($dossier['diagnostic']); ?></p>
                    <p><strong>Traitement :</strong> <?php echo htmlspecialchars($dossier['traitement']); ?></p>
                    <p><strong>Docteur :</strong> <?php echo htmlspecialchars($dossier['prenom_docteur'] . ' ' . $dossier['nom_docteur']); ?></p>
                    <p><strong>Specialité :</strong> <?php echo htmlspecialchars($dossier['idspecialiste']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($dossier['email']); ?></p>
                    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($dossier['tel']); ?></p>
                      
                    <?php if (!empty($dossier['resultat'])): ?>
                        <p><strong>Résultats d'examen :</strong> <a href="telecharger.php?fichier=<?php echo urlencode($dossier['chemin_fichier']); ?>">Télécharger</a></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun dossier médical ou résultat trouvé.</p>
        <?php endif; ?>
        
        <a href="?download=true" class="btn">Télécharger mon dossier médical</a>
    </main>
</body>
</html>
