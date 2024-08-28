<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$msgSuccess = '';
$msgErreur = '';

// Récupérer les spécialités depuis la base de données
$specialistes = [];
try {
    $stmt = $pdo->query("SELECT idspecialiste, nomspecialiste FROM specialiste");
    $specialistes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $msgErreur = "Erreur lors de la récupération des spécialités: " . $e->getMessage();
}

// Vérifiez que l'email est défini dans la session
if (isset($_SESSION['email'])) {
    $stmt = $pdo->prepare("SELECT idpatient FROM patient WHERE email = :email");
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->execute();
    $patient_id = $stmt->fetchColumn();
} else {
    $msgErreur = "Erreur: L'email du patient n'est pas défini dans la session.";
}

if (isset($_POST['submit'])) {
    if (isset($_POST['description'], $_POST['duree'], $_POST['idspecialiste'])) {
        if (!empty($_POST['description']) && !empty($_POST['duree']) && !empty($_POST['idspecialiste']) && !empty($patient_id)) {
            $description = $_POST["description"];
            $duree = $_POST["duree"];
            $idspecialiste = $_POST["idspecialiste"];
            
            try {
                // Insertion dans la base de données
                $insert = $pdo->prepare("INSERT INTO consultation (description, duree, idspecialiste, idpatient) VALUES (?, ?, ?, ?)");
                $execute = $insert->execute([$description, $duree, $idspecialiste, $patient_id]);
                $idconsultation=$pdo->lastInsertId();

                // Si l'insertion est réussie
                if ($execute) {
                    $msgSuccess = "Rendez-vous programmé avec succès.";
                    header("Location: choix.php?idspecialiste=" . urlencode($idspecialiste)."&idconsultation=" . urlencode($idconsultation));
                    exit(); 
                }
            } catch (PDOException $e) {
                $msgErreur = "Erreur: " . $e->getMessage();
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../inc/csssymptome.php"); ?>
    <title>Formulaire des Symptômes</title>
</head>

<body>

    <h1>Déclaration des Symptômes</h1>

    <div class="container">
        <form action="" id="symptomForm" method="POST">
            <div>
                <label for="symptomes">Description des Symptômes :</label>
                <textarea id="symptomes" name="description" rows="4" placeholder="Décrivez vos symptômes..." required></textarea>
            </div>
            
            <div>
                <label for="duree">Durée des Symptômes :</label>
                <input type="text" id="duree" name="duree" placeholder="Ex. : 3 jours" required>
            </div>
            <div>
                <label for="idspecialiste">Spécialité:</label>
                <select id="idspecialiste" name="idspecialiste" required>
                    <option value="">Sélectionnez votre spécialité</option>
                    <?php foreach ($specialistes as $specialiste): ?>
                        <option value="<?php echo htmlspecialchars($specialiste['idspecialiste']); ?>">
                            <?php echo htmlspecialchars($specialiste['nomspecialiste']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" name="submit">Soumettre</button>
            </div>
        </form>

        <?php if ($msgSuccess): ?>
            <p style="color: green;"><?php echo $msgSuccess; ?></p>
        <?php endif; ?>
        
        <?php if ($msgErreur): ?>
            <p style="color: red;"><?php echo $msgErreur; ?></p>
        <?php endif; ?>
    </div>

</body>
</html>
