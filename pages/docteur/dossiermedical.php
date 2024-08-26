<?php
// Connexion à la base de données
require_once("../../inc/connexion.php");

// Vérifier si un patient est sélectionné
if (isset($_GET['idpatient']) && !empty($_GET['idpatient'])) {
    $idpatient = $_GET['idpatient'];
    
    // Récupérer les informations du patient
    $patientQuery = $pdo->prepare("SELECT * FROM patient WHERE idpatient = ?");
    $patientQuery->execute([$idpatient]);
    $patient = $patientQuery->fetch();

    // Récupérer les informations du dossier médical
    $dossierQuery = $pdo->prepare("SELECT * FROM dossiermedical WHERE idpatient = ?");
    $dossierQuery->execute([$idpatient]);
    $dossier = $dossierQuery->fetchAll();
} else {
    echo "Aucun patient sélectionné.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $idpatient = $_POST['idpatient'];
    $diagnostic = $_POST['diagnostic'];
    $traitement = $_POST['traitement'];

    // Préparer et exécuter la requête d'insertion
    $stmt = $pdo->prepare("INSERT INTO dossiermedical (idpatient, diagnostic, traitement, datedernieremiseajour) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$idpatient, $diagnostic, $traitement]);

    // Redirection vers le dossier médical du patient après la mise à jour
    header("Location: dossiermedical.php?idpatient=" . $idpatient);
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
  
    <h3>Historique Médical</h3>
    <?php if ($dossier): ?>
        <ul>
            <?php foreach ($dossier as $entry): ?>
                <li>
                    <strong>Diagnostic :</strong> <?php echo htmlspecialchars($entry['diagnostic']); ?><br>
                    <strong>Traitements :</strong> <?php echo htmlspecialchars($entry['traitement']); ?><br>
                    <strong>Date :</strong> <?php echo htmlspecialchars($entry['datedernieremiseajour']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune information disponible.</p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter des notes -->
    <h3>Ajouter une Note</h3>
    <form method="POST" action="">
        <input type="hidden" name="idpatient" value="<?php echo htmlspecialchars($idpatient); ?>">
        
        <label for="diagnostic">Diagnostic :</label>
        <textarea name="diagnostic" required></textarea>
        
        <label for="traitement">Traitements :</label>
        <textarea name="traitement"></textarea>
        
        <button type="submit">Sauvegarder</button>
    </form>
</body>
</html>
