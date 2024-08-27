<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];
$tof = $_SESSION['tof'];
$nom = $_SESSION['nom'];

// Connexion à la base de données
require_once("../../inc/connexion.php");

// Préparer et exécuter la requête pour obtenir les informations du médecin et du patient via la jointure
$stmt = $pdo->prepare("
    SELECT docteur.nom AS nom_docteur, docteur.prenom AS prenom_docteur, docteur.tel AS tel_docteur, 
    docteur.email AS email_docteur, docteur.grade AS grade_docteur, docteur.diplome AS diplome_docteur,
     docteur.certificat AS certificat_docteur, specialiste.nomspecialiste AS specialite_docteur, 
     patient.nom AS nom_patient, patient.prenom AS prenom_patient FROM docteur 
     JOIN specialiste ON docteur.idspecialiste = specialiste.idspecialiste JOIN 
     dossiermedical ON docteur.iddocteur = dossiermedical.iddocteur 
     JOIN patient ON dossiermedical.idpatient = patient.idpatient LIMIT 1;
");

$docteur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$docteur) {
    echo "<p>Aucun médecin trouvé pour ce patient.</p>";
} else {
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mon Docteur</title>
        <link rel="stylesheet" href="../../css/dashboard.css">
        <link rel="stylesheet" href="../../icons/all.min.css">
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            .doctor-info {
                margin: 20px;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #f9f9f9;
            }
            h2 {
                margin-bottom: 20px;
            }
            p {
                margin: 10px 0;
            }
        </style>
    </head>
    <body>

    <section id="sidebar">
        <?php include("../../inc/sidebar4.php"); ?>
    </section>
    <section id="content">
        <nav>
            <?php include("../../inc/nav4.php"); ?>
        </nav>
        <main>
            <section class="doctor-info">
                <h2>Informations sur mon médecin</h2>
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($docteur['nom_docteur']) . " " . htmlspecialchars($docteur['prenom_docteur']); ?></p>
                <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($docteur['specialite_docteur']); ?></p>
                <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($docteur['tel_docteur']); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($docteur['email_docteur']); ?></p>
                <p><strong>Grade :</strong> <?php echo htmlspecialchars($docteur['grade_docteur']); ?></p>
                <p><strong>Diplôme :</strong> <?php echo htmlspecialchars($docteur['diplome_docteur']); ?></p>
                <p><strong>Certificat :</strong> <?php echo htmlspecialchars($docteur['certificat_docteur']); ?></p>
            </section>
        </main>

        <script src="../../js/all.min.js"></script>
        <script src="../../js/script.js"></script>
    </body> 
    </html>

    <?php
}
?>
