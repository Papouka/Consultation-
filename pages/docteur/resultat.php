<?php

session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idpatient = $_POST['idpatient'];
    $typeexamen = $_POST['typeexamen'];
    $resultat = $_POST['resultat'];

    // Insérer le résultat dans la base de données
    $stmt = $pdo->prepare("INSERT INTO resultat (idpatient, typeexamen, resultat, dateexamen) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$idpatient, $typeexamen, $resultat]);

    // Récupérer les informations du patient
    $patientQuery = $pdo->prepare("SELECT * FROM patient WHERE idpatient = ?");
    $patientQuery->execute([$idpatient]);
    $patient = $patientQuery->fetch();

    // Envoyer un email au patient
    if ($patient) {
        $to = $patient['email'];
        $subject = "Résultats de vos examens";
        $message = "Bonjour " . htmlspecialchars($patient['prenom']) . ",\n\nVoici les résultats de vos examens :\n\n" . htmlspecialchars($resultat);
        $headers = "From: noreply@votresite.com";

        mail($to, $subject, $message, $headers);
        echo "Résultat enregistré et email envoyé.";
    } else {
        echo "Patient introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer les Résultats d'Examen</title>
</head>
<body>
    <h1>Enregistrer les Résultats d'Examen</h1>
    <form method="POST" action="">
        <label for="idpatient">ID Patient :</label>
        <input type="text" id="idpatient" name="idpatient" required>

        <label for="type_examen">Type d'Examen :</label>
        <input type="text" id="type_examen" name="typeexamen" required>

        <label for="resultat">Résultat :</label>
        <textarea id="resultat" name="resultat" required></textarea>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
