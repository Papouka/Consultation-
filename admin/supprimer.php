<?php
session_start();

// Inclure le fichier de connexion
try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Vérifier si l'ID est passé en paramètre
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer la requête pour supprimer la spécialité
    try {
        $stmt = $pdo->prepare("DELETE FROM specialiste WHERE id = ?");
        $stmt->execute([$id]);

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
