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
    <form action="#"  id="symptomForm" method="POST">
        
        
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

<script>
    document.getElementById('symptomForm').onsubmit = function(event) {
        event.preventDefault();
        // Code pour traiter les symptômes si nécessaire
        window.location.href = '../pages/choix.php'; // Redirection vers la page de choix du docteur
    };
</script>

</body>
</html>
