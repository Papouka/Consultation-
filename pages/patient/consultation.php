<?php
require_once("../../actions/consultationAction.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Médicale</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
</head>
<body>
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

<section id="sidebar">
    <?php include("../../inc/sidebar4.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav4.php"); ?>
    </nav>
    <main>
        <div class="container">
            <h1>Mes Consultations</h1>
            <?php if (isset($consultation) && count($consultation) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date et Heure</th>
                            <th>Docteur</th>
                            <th>Spécialiste</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultation as $c): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($c['dateconsultation']); ?></td>
                                <td>Dr. <?php echo htmlspecialchars($c['nom']) . ' ' . htmlspecialchars($c['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($c['nomspecialiste']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune consultation trouvée.</p>
            <?php endif; ?>
        </div>
    </main>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
