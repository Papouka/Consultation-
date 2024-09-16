<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Vérifier si l'ID est passé en paramètre
if (isset($_GET['idspecialiste'])) {
    $idspecialiste = $_GET['idspecialiste'];

    try {
        // Assurez-vous que le nom de la colonne est correct
        $stmt = $pdo->prepare("DELETE FROM specialiste WHERE id = ?"); // Changez ici si nécessaire
        $stmt->execute([$idspecialiste]);

        // Rediriger après succès
        header("Location: ../admin/ajoutspecialite.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
} else {
    die("ID non spécifié.");
}
?>
