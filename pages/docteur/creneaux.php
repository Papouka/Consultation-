<?php
require_once("../../actions/creneauAction.php");
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
<section id="sidebar">
    <?php include("../../inc/sidebar4.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav4.php"); ?>
    </nav>

<h1>Gestion des Créneaux Horaires</h1>

<!-- Formulaire d'ajout de créneau -->
<form method="POST" action="">
    <label for="date">Date :</label>
    <input type="date" name="date" required>
    
    <label for="heure_debut">Heure de début :</label>
    <input type="time" name="heure_debut" required>
    
    <label for="heure_fin">Heure de fin :</label>
    <input type="time" name="heure_fin" required>
    
    <button type="submit" name="ajouter">Ajouter Créneau</button>
</form>

<h2>Créneaux Existants</h2>
<ul>
    <?php if (!empty($creneaux)): ?>
        <?php foreach ($creneaux as $creneau): ?>
            <li>
                <?php echo htmlspecialchars($creneau['date'] . ' de ' . $creneau['heure_debut'] . ' à ' . $creneau['heure_fin']); ?>
                <?php if (!$creneau['bloque']): ?>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="idcreneau" value="<?php echo $creneau['idcreneau']; ?>">
                        <button type="submit" name="bloquer">Bloquer</button>
                    </form>
                <?php else: ?>
                    <span style="color:red;">(Bloqué)</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>Aucun créneau existant.</li>
    <?php endif; ?>
</ul>

<script src="../../js/all.min.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>
