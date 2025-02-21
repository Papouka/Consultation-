<?php
session_start();

// Connexion à la base de données avec PDO
try {
    $connect = new PDO("mysql:host=localhost;dbname=your_database_name", "your_username", "your_password");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Récupération des données POST
$iddocteur = $_POST["iddocteur"];
$idpatient = $_POST["idpatient"];
$message = $_POST["message"];

$output = "";

// Préparation de la requête d'insertion
$sql = "INSERT INTO message (iddocteur, idpatient, message) VALUES (:iddocteur, :idpatient, :message)";
$stmt = $connect->prepare($sql);

// Exécution de la requête avec des paramètres
try {
    $stmt->execute([
        ':iddocteur' => $iddocteur,
        ':idpatient' => $idpatient,
        ':message' => $message
    ]);
    $output .= "Message envoyé avec succès.";
} catch (PDOException $e) {
    $output .= "Erreur : " . $e->getMessage();
}

// Affichage du résultat
echo $output;
?>
