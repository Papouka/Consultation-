<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];
$tof = $_SESSION['tof'];
$nom = $_SESSION['nom'];
$idpatient = $_SESSION['patient'];
// Connexion à la base de données
require_once("../../inc/connexion.php");

// Préparer et exécuter la requête pour obtenir les informations des docteurs associés au patient
$stmt = $pdo->prepare("SELECT DISTINCT docteur.* 
                        FROM docteur, consultation,patient 
                        WHERE docteur.iddocteur = consultation.iddocteur 
                        AND consultation.idpatient= patient.idpatient 
                      "
    );
   ;
    $stmt->execute();

// Vérifier si la requête a retourné des résultats
if ($stmt->rowCount() > 0) {
    $docteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mes Docteurs</title>
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
                    
                    
                    <h2>Informations sur mes docteurs</h2>
                    <?php foreach ($docteurs as $docteur): ?>
                        <div>
                            <p><strong>Nom :</strong> <?php echo htmlspecialchars($docteur['nom']) . " " . htmlspecialchars($docteur['prenom']); ?></p>
                            <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($docteur['idspecialiste']); ?></p>
                            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($docteur['tel']); ?></p>
                            <p><strong>Email :</strong> <?php echo htmlspecialchars($docteur['email']); ?></p>
                            <p><strong>Ville :</strong> <?php echo htmlspecialchars($docteur['ville']); ?></p>
                            <p><strong>Diplôme :</strong> <?php echo htmlspecialchars($docteur['diplome']); ?></p>
                            <p><strong>Certificat :</strong> <?php echo htmlspecialchars($docteur['certificat']); ?></p>
                            <hr>
                        </div>
                    <?php endforeach; ?>
                </section>
            </main>
            <script src="../../js/all.min.js"></script>
            <script src="../../js/script.js"></script>
        </body>
    </html>
    <?php
} else {
    echo "Aucun docteur trouvé pour ce patient.";
}
?>
