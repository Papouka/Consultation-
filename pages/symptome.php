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

if (isset($_POST['submit'])) {
    if (isset($_POST['description'], $_POST['duree'])) {
        if (!empty($_POST['description']) && !empty($_POST['duree'])) {
            $description = $_POST["description"];
            $duree = $_POST["duree"];
            
            try {
                // Insertion dans la base de données
                $insert = $pdo->prepare("INSERT INTO consultation (description, duree) VALUES (?, ?)");
                $execute = $insert->execute([$description, $duree]);

                // Si l'insertion est réussie
                if ($execute) {
                    $msgSuccess = "Rendez-vous programmé avec succès.";
                    header("Location: ../pages/choix.php"); // Redirection après succès
                    exit(); // Arrête le script après la redirection
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
                <input type="time" id="duree" name="duree" placeholder="Ex. : 3 jours" required>
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
