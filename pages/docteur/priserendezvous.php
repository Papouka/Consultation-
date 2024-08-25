<?php
require_once("../../actions/priserdvAction.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Consultation</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
</head>
<body>

<section id="sidebar">
    <?php include("../../inc/sidebar4.php"); ?>
</section>

<section id="content">
    <nav>
        <?php include("../../inc/nav4.php"); ?>
    </nav>
    <main>
        <h2></h2>

        <?php if (!empty($msgErreur)): ?>
            <div class="error-msg"><?php echo $msgErreur; ?></div>
        <?php endif; ?>

        <?php if (!empty($msgSuccess)): ?>
            <div class="success-msg"><?php echo $msgSuccess; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            

            <div>
                <label for="dateconsultation">Date consultation :</label>
                <input type="date" name="dateconsultation" id="dateconsultation" required>
            </div>

            <div>
                <label for="heure">Heure :</label>
                <input type="time" name="heure" id="heure" required>
            </div>

            

            <div>
                <label for="diagnostic">Diagnostic :</label>
                <input type="text" name="diagnostic" id="diagnostic" required>
            </div>

            <div>
                <label for="traitement">Traitement :</label>
                <input type="text" name="traitement" id="traitement" required>
            </div>

           
            <div>
                <button type="submit" class="button">Ajouter la Consultation</button>
            </div>
        </form>
    </main>

    <script src="../../js/all.min.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
