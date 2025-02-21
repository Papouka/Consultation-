<?php


if (!isset($_SESSION['iddocteur']) || !isset($_SESSION['idpatient'])) {
    die("Erreur : Identifiants manquants.");
}

$iddocteur = $_SESSION['iddocteur'];
$idpatient = $_SESSION['idpatient'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM message WHERE idpatient = :idpatient AND iddocteur = :iddocteur ORDER BY dateenvoie ASC");
$stmt->bindParam(':idpatient', $idpatient);
$stmt->bindParam(':iddocteur', $iddocteur);
$stmt->execute();

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as $msg) {
    if ($msg['auteur'] === 'patient') {
        echo "<div class='message-received'><strong>Vous :</strong> " . htmlspecialchars($msg['message']) . " <em>(" . htmlspecialchars($msg['dateenvoie']) . ")</em></div>";
    } else if ($msg['auteur'] === 'docteur') {
        echo "<div class='message-sent'><strong>Docteur :</strong> " . htmlspecialchars($msg['message']) . " <em>(" . htmlspecialchars($msg['dateenvoie']) . ")</em></div>";
    }
}
?>
