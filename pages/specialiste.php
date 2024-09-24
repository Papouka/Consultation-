<?php
session_start();


if (!isset($_SESSION['email'])) {
    
    header("Location: ../login.php");
    exit(); 
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$docteur = [];
if (isset($_GET['idspecialiste'])) {
    $idspecialiste = $_GET['idspecialiste'];
    
    // Récupérer les valeurs de filtrage
    $experience = isset($_GET['experience']) ? $_GET['experience'] : '';
    $patients = isset($_GET['patients']) ? $_GET['patients'] : '';

    // Préparer la requête pour récupérer les docteurs
    try {
        // Construire la requête SQL
        $query = "SELECT * FROM docteur WHERE idspecialiste = :idspecialiste";
        
        // Ajouter des conditions pour le filtrage
        if (!empty($experience)) {
            $query .= " AND experience >= :experience";
        }
        if (!empty($patients)) {
            $query .= " AND nombre_patients >= :patients"; // Assurez-vous que la colonne nombre_patients existe dans votre base de données
        }

        // Préparer la requête
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idspecialiste', $idspecialiste, PDO::PARAM_INT);
        
        // Lier les paramètres de filtrage
        if (!empty($experience)) {
            $stmt->bindParam(':experience', $experience, PDO::PARAM_INT);
        }
        if (!empty($patients)) {
            $stmt->bindParam(':patients', $patients, PDO::PARAM_INT);
        }

        // Exécuter la requête
        $stmt->execute();
        $docteur = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des docteurs : " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Docteurs</title>
    <link rel="stylesheet" href="../icons/all.min.css">
    <script src="../js/all.min.js"></script>
    <link rel="stylesheet" href="../css/patient.css">
    <link rel="stylesheet" href="../css/index.css">
    <?php include("../inc/cssspecialiste.php"); ?>
    <?php include("../admin/css.php"); ?>
</head>
<body>
<header>
    <?php include("../inc/header.php"); ?>
</header>

<h1>Liste des docteurs spécialisés</h1>

<!-- Formulaire de filtrage -->
<form method="GET" action="">
    <div>
        <label for="experience">Années d'expérience :</label>
        <input type="number" name="experience" id="experience" min="0">
    </div>
    <div>
        <label for="patients">Nombre de patients :</label>
        <input type="number" name="patients" id="patients" min="0">
    </div>
    <button type="submit">Filtrer</button>
    <input type="hidden" name="idspecialiste" value="<?php echo htmlspecialchars($idspecialiste); ?>">
</form>

<?php if (!empty($docteur)): ?>
    <ul>
        <?php foreach ($docteur as $index => $doc): ?>
            <li>
                <div class="card">
                    <img src="../<?php echo htmlspecialchars($doc['tof']); ?>" alt="<?php echo htmlspecialchars($doc['nom']); ?>">
                    <h2>DR. <?php echo htmlspecialchars($doc['nom']); ?></h2>
                    <p><label for=""> Prénom: </label><?php echo htmlspecialchars($doc['prenom']); ?></p>
                    <p><label for=""> Email: </label><?php echo htmlspecialchars($doc['email']); ?></p>
                    <p><label for=""> Coût  de la consultation : </label><?php echo htmlspecialchars($doc['prix']); ?> FCFA</p>
                    <p><label for=""> Numéro de téléphone: </label><?php echo htmlspecialchars($doc['tel']); ?></p>
                </div>
                <div id="myModal<?php echo $index; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" data-index="<?php echo $index; ?>">&times;</span>
                        <form method="POST">
                            <h3>Mes informations</h3>
                            <p><label for="" class="lor">Diplôme: </label><?php echo htmlspecialchars($doc['diplome']); ?></p>
                            <p><label for="" class="lor"> Ville: </label><?php echo htmlspecialchars($doc['ville']); ?></p>
                            <p><label for="" class="lor"> Année d'expérience: </label><?php echo htmlspecialchars($doc['experience']); ?> ans</p>
                        </form>
                    </div>
                </div>
                <div class="buttons">
                    <button class="button openModal" data-index="<?php echo $index; ?>">Détails</button>
                    <a href="../pages/patient/rendezvous.php?iddocteur=<?php echo htmlspecialchars($doc['iddocteur']); ?>">
    
                        <button class="button">Prendre Rendez-vous</button>
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun docteur trouvé pour cette spécialité.</p>
<?php endif; ?>

<footer>
    <?php include("../inc/footer.php"); ?>
</footer>
<script>
    // Gestion de l'ouverture et de la fermeture des modales
    document.querySelectorAll('.openModal').forEach(button => {
        button.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            document.getElementById('myModal' + index).style.display = 'block';
        });
    });

    document.querySelectorAll('.close').forEach(span => {
        span.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            document.getElementById('myModal' + index).style.display = 'none';
        });
    });

    window.addEventListener('click', function(event) {
        document.querySelectorAll('.modal').forEach(modal => {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
