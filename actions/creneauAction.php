<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['iddocteur'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $iddocteur = $_SESSION['iddocteur'];

    // Ajouter un créneau
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
        $date = $_POST['date'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];

        $stmt = $pdo->prepare("INSERT INTO creneaux (iddocteur, date, heure_debut, heure_fin) VALUES (:iddocteur, :date, :heure_debut, :heure_fin)");
        $stmt->execute([
            ':iddocteur' => $iddocteur,
            ':date' => $date,
            ':heure_debut' => $heure_debut,
            ':heure_fin' => $heure_fin
        ]);
    }

    // Bloquer un créneau
    if (isset($_POST['bloquer'])) {
        $creneau_id = $_POST['idcreneau'];
        $stmt = $pdo->prepare("UPDATE creneaux SET bloque = TRUE, disponible = FALSE WHERE idcreneau = :id");
        $stmt->execute([':id' => $creneau_id]);
    }

    // Récupérer les créneaux existants
    $stmt = $pdo->prepare("SELECT * FROM creneaux WHERE iddocteur = :iddocteur");
    $stmt->execute([':iddocteur' => $iddocteur]);
    $creneaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Débogage : afficher le nombre de créneaux récupérés
    echo "<pre>Nombre de créneaux récupérés : " . count($creneaux) . "</pre>";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>