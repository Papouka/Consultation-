<?php
session_start();

 
try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if (isset($_GET['id'])) {
    $idspecialiste = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM specialiste WHERE id = ?");
        $stmt->execute([$idspecialiste]);
        $specialite = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$specialite) {
            die("Spécialité non trouvée.");
        }
    } catch (PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
} else {
    die("ID non spécifié.");
}

// Traitement du formulaire de mise à jour
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['description'])) {
        if (!empty($_POST['nom']) && !empty($_POST['description'])) {
            $nom = $_POST['nom'];
            $description = $_POST['description'];

            try {
                $update = $pdo->prepare("UPDATE specialiste SET nom = ?, description = ? WHERE idspecialiste = ?");
                $execute = $update->execute([$nom, $description, $idspecialiste]);

                if ($execute) {
                    header("Location: ../admin/ajoutspecialite.php"); // Rediriger après succès
                    exit();
                } else {
                    $msgErreur = "Échec de la mise à jour.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Spécialité</title>
</head>
<body>
    <h1>Modifier Spécialité</h1>
    <form method="POST">
        <input type="text" name="nom" value="<?= htmlspecialchars($specialite['nom']) ?>" required>
        <textarea name="description" required><?= htmlspecialchars($specialite['description']) ?></textarea>
        <button type="submit" name="submit">Mettre à jour</button>
    </form>
    <?php if (!empty($msgErreur)): ?>
        <p style="color: red;"><?= $msgErreur ?></p>
    <?php endif; ?>
</body>
</html>
