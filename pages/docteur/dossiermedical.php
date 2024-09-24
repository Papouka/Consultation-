<?php
session_start();
// Connexion à la base de données
require_once("../../inc/connexion.php");

// Vérifier si un patient est sélectionné
if (isset($_GET['idpatient'])) {
    $idpatient = $_GET['idpatient'];
    
   
    if (isset($_SESSION['docteur'])) {
        $iddocteur = $_SESSION['docteur'];

        // Récupération des informations du patient
        $patientQuery = $pdo->prepare("SELECT * FROM patient WHERE idpatient = ?");
        $patientQuery->execute([$idpatient]);
        $patient = $patientQuery->fetch();

        if (!$patient) {
            echo "Patient non trouvé.";
            exit();
        }

        // Récupération des informations du docteur
        $docteurQuery = $pdo->prepare("SELECT * FROM docteur WHERE iddocteur = ?");
        $docteurQuery->execute([$iddocteur]);
        $docteur = $docteurQuery->fetch();

        if (!$docteur) {
            echo "Docteur non trouvé.";
            exit();
        }

        // Récupération de l'ID du spécialiste associé au docteur
        $idspecialiste = $docteur['idspecialiste'];

        // Récupération des consultations
        $consultationQuery = $pdo->prepare("SELECT * FROM consultation WHERE idpatient = ?");
        $consultationQuery->execute([$idpatient]);
        $consultations = $consultationQuery->fetchAll();

        // Traitement du formulaire d'ajout de consultation
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
            // Récupérer les données du formulaire
            $diagnostic = $_POST['diagnostic'] ?? '';
            $traitement = $_POST['traitement'] ?? '';
            $typeexamen = $_POST['typeexamen'] ?? '';

            // Vérifier que les champs requis sont remplis
            if (empty($diagnostic)) {
                echo "Le diagnostic est requis.";
            } else {
                // Préparer et exécuter la requête d'insertion
                $stmt = $pdo->prepare("INSERT INTO consultation (idpatient, iddocteur, idspecialiste, diagnostic, traitement, typeexamen, datedernieremiseajour) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$idpatient, $iddocteur, $idspecialiste, $diagnostic, $traitement, $typeexamen]);

                // Redirection vers la page des consultations après la mise à jour
                header("Location: dossiermedical.php?idpatient=" . $idpatient);
                exit();
            }
        }

        // Traitement de la modification de consultation
        if (isset($_POST['modification'])) {
            $idconsultation = $_GET['idconsultation'];
            $iddocteur = $_POST['iddocteur'];
            
            $stmt = $pdo->prepare("UPDATE consultation SET iddocteur = :iddocteur WHERE idconsultation = :idconsultation");
            $stmt->bindParam(':iddocteur', $iddocteur);
            $stmt->bindParam(':idconsultation', $idconsultation);
            $stmt->execute();
            
            header("Location: ../pages/patient/rendezvous.php?iddocteur=$iddocteur");
            exit();
        }
    } else {
        echo "Aucun docteur sélectionné.";
        exit();
    }
} else {
    echo "Aucun patient sélectionné.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dossier Médical de <?php echo htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']); ?></title>
</head>
<body>
    <h2>Dossier Médical de <?php echo htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']); ?></h2>
    
    <!-- Affichage des informations personnelles -->
    <h3>Informations Personnelles</h3>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($patient['nom']); ?></p>
    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($patient['prenom']); ?></p>
  
    <h3>Historique des Consultations</h3>
    <?php if ($consultations): ?>
        <ul>
            <?php foreach ($consultations as $entry): ?>
                <li>
                    <strong>Diagnostic :</strong> <?php echo htmlspecialchars($entry['diagnostic']); ?><br>
                    <strong>Traitements :</strong> <?php echo htmlspecialchars($entry['traitement']); ?><br>
                    <strong>Type d'examen :</strong> <?php echo htmlspecialchars($entry['typeexamen']); ?><br>
                    <strong>Date :</strong> <?php echo htmlspecialchars($entry['datedernieremiseajour']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune consultation disponible.</p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter une consultation -->
    <h3>Ajouter une Consultation</h3>
    <form method="POST" action="">
        <input type="hidden" name="idpatient" value="<?php echo htmlspecialchars($idpatient); ?>">
        <input type="hidden" name="iddocteur" value="<?php echo htmlspecialchars($iddocteur); ?>">
        <input type="hidden" name="idspecialiste" value="<?php echo htmlspecialchars($idspecialiste); ?>" readonly>
        
        <label for="diagnostic">Diagnostic :</label>
        <textarea name="diagnostic" required></textarea>
        
        <label for="traitement">Traitements :</label>
        <textarea name="traitement"></textarea>
        
        <label for="typeexamen">Type examen :</label>
        <textarea name="typeexamen"></textarea>
        
        <button type="submit" name="ajouter">Sauvegarder</button>
    </form>
</body>
</html>
