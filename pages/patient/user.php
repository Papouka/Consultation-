<?php
session_start(); // Assurez-vous que la session est démarrée

// Inclure la connexion à la base de données avec PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    die("Utilisateur non connecté.");
}

// Supposons que le rôle de l'utilisateur soit stocké dans $_SESSION['role']
$role = $_SESSION['role'];

// Vérifier si l'utilisateur est un docteur ou un médecin
if ($role !== 'docteur' && $role !== 'médecin') {
    die("Accès refusé. Vous devez être un docteur ou un médecin.");
}

// Gestion de l'upload de photo
if (isset($_FILES['tof']) && $_FILES['tof']['error'] == 0) {
    // Dossier de destination pour les photos uploadées
    $uploadDir = 'img/';
    
    // Vérifier si le dossier existe, sinon le créer
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Chemin de destination du fichier
    $tofPath = $uploadDir . basename($_FILES['tof']['name']);

    // Vérifier le type de fichier (optionnel mais recommandé)
    $fileType = strtolower(pathinfo($tofPath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedTypes)) {
        // Déplacer le fichier uploadé dans le répertoire cible
        if (move_uploaded_file($_FILES['tof']['tmp_name'], $tofPath)) {
            // Mettre à jour la base de données avec le nouveau chemin de l'image
            $updateSql = "UPDATE utilisateurs SET tof = ? WHERE id_utilisateur = ?";
            $updateStmt = $pdo->prepare($updateSql);

            if ($updateStmt->execute([$tofPath, $_SESSION['id_utilisateur']])) {
                // Mettre à jour la session avec le nouveau chemin de l'image
                $_SESSION['tof'] = $tofPath;
                echo "Photo mise à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour de la base de données.";
            }
        } else {
            echo "Erreur lors du déplacement du fichier uploadé.";
        }
    } else {
        echo "Type de fichier non autorisé. Veuillez télécharger une image au format JPG, JPEG, PNG ou GIF.";
    }
} else {
    echo "Aucune photo téléchargée ou erreur lors du téléchargement.";
}
?>
