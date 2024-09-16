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


$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
$iddoct = $_SESSION['iddocteur']; 

// Récupérer la liste des rendez-vous pour le médecin
$stmt = $pdo->prepare("SELECT * FROM consultation   JOIN patient  ON consultation.idpatient = patient.idpatient   
     ");
$stmt->execute();
$rendezvous = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Rendez-vous</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers votre fichier CSS -->
</head>
<style>
.container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f4f4f4;
}
h1 {
    text-align: center;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
th {
    background-color: green;
    color: white;
}
</style>
<body>
<section id="sidebar">
        <?php include("../../inc/sidebar2.php"); ?>
    </section>
    <section id="content">
        <nav>
            <?php include("../../inc/nav2.php"); ?>
        </nav>
    <h1>Liste de vos Rendez-vous</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Patient</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if (count($rendezvous) > 0): ?>
                <?php foreach ($rendezvous as $rdv): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($rdv['dateconsultation']))); ?></td>
                        <td><?php echo htmlspecialchars(date('H:i', strtotime($rdv['dateconsultation']))); ?></td>
                        <td><?php echo htmlspecialchars($rdv['prenom'] . ' ' . $rdv['nom']); ?></td>
                       
                       
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun rendez-vous trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/chart.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
