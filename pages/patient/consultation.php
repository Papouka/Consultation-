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
    background-color: #007BFF;
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
    <?php if (count($consultations) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Docteur</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultations as $consultation): ?>
                    <tr>
                        <td><input type="hidden" name="idpatient" value="<?php echo htmlspecialchars($idpatient); ?>"></td>
                    <td><input type="hidden" name="idpatient" value="<?php echo ($iddocteur); ?>"></td>
                        <td><?php echo htmlspecialchars($consultation['dateconsultation']); ?></td> <!-- Assurez-vous que 'date' est le bon nom -->
                        <td>Dr. <?php echo htmlspecialchars($consultation['prenom'] . ' ' . $consultation['nom']); ?></td>
                      
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
