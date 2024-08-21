<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../inc/csssymptome.php"); ?>
    <title>Formulaire des Symptômes</title>
</head>


<body>


    <h1>Déclaration des Symptômes</h1>


<div class="container">
    <form action="traitement_symptomes.php" method="POST">
        <div>
            <label for="nom">Nom du Patient :</label>
            <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
        </div>
        
        <div>
            <label for="symptomes">Description des Symptômes :</label>
            <textarea id="symptomes" name="symptomes" rows="4" placeholder="Décrivez vos symptômes..." required></textarea>
        </div>
        
        <div>
            <label for="duree">Durée des Symptômes :</label>
            <input type="time" id="duree" name="duree" placeholder="Ex. : 3 jours" required>
        </div>
        
        <div>
            <label for="urgence">Avez-vous besoin d'une consultation urgente ?</label>
            <select id="urgence" name="urgence" required>
                <option value="">Sélectionnez</option>
                <option value="oui">Oui</option>
                <option value="non">Non</option>
            </select>
        </div>
        
        <div>
            <button type="submit">Soumettre</button>
        </div>
    </form>
</div>



</body>
</html>
