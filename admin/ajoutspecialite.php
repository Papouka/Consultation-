<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Initialiser les messages
$msgSuccess = '';
$msgErreur = '';

// Traitement du formulaire
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['description'])) {
        if (!empty($_POST['nom']) && !empty($_POST['description'])) {
            $nom = $_POST['nom'];
            $description = $_POST['description'];

            try {
                $insert = $pdo->prepare("INSERT INTO specialiste (nom, description) VALUES (?, ?)");
                $execute = $insert->execute([$nom, $description]);
                
                if ($execute) {
                    $_SESSION['nom'] = $nom;
                    $msgSuccess = "Informations enregistrées.";
                } else {
                    $msgErreur = "Échec de l'enregistrement.";
                }
            } catch (PDOException $e) {
                $msgErreur = "Erreur: " . $e->getMessage();
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}

// Lire les spécialités
$stmt = $pdo->query("SELECT * FROM specialiste");
$specialites = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Affichage des messages
if (!empty($msgSuccess)) {
    echo "<p style='color: green;'>$msgSuccess</p>";
}
if (!empty($msgErreur)) {
    echo "<p style='color: red;'>$msgErreur</p>";
}
if (!isset($_SESSION['email'])) {
   header("Location: login.php");
   exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

?>

<!DOCTYPE html>
<html lang="fr"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCUEIL</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../icons/all.min.css">
    <?php include("../admin/css.php"); ?>
   
</head>

<body>
    <section id="sidebar">
        <?php include("sidebar3.php"); ?>
    </section>
    <section id="content">
        <nav>
            <?php include("nav3.php"); ?>
        </nav>
        <main>
            <h1 class="title">Dashboard</h1>
             
            <ul class="breadcrumbs">
                <li><a href="../admin/index.php">Accueil</a></li> 
                <li class="divider">/</li>
                <li><a href="../admin/index.php" class="active">Dashboard</a></li>
            </ul>
            

<!-- Le Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Titre du Modal</h2>
        <form method="POST">
                <input type="text" name="nom" placeholder="Nom de la spécialité" required><br><br>
                <textarea name="description" placeholder="Description" required></textarea> <br><br>
                <button type="submit" name="submit">Ajouter</button>
            </form>
    </div>
</div>
            <!-- Formulaire d'ajout de spécialité -->
           

            <!-- Tableau d'affichage des spécialités -->
            <h2>Liste des spécialités</h2>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php if (!empty($specialites)): ?>
                    <?php foreach ($specialites as $specialite): ?>
                    <tr>
                        <td><?= htmlspecialchars($specialite['id']) ?></td>
                        <td><?= htmlspecialchars($specialite['nom']) ?></td>
                        <td><?= htmlspecialchars($specialite['description']) ?></td>
                        <td>
                            <a href="../admin/modifier.php?id=<?= htmlspecialchars($specialite['id']) ?>"> <i class="fa fa-pencil" aria-hidden="true"></i> </a>
                            <a href="../admin/supprimer.php?id=<?= htmlspecialchars($specialite['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette spécialité ?');"> <i class="fa fa-trash alert-red" aria-hidden="true" ></i>
                            </a>
                        </td>
                    </tr>
                    



<script src="script.js"></script>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucune spécialité trouvée.</td>
                    </tr>
                <?php endif; ?>
            </table>
            <br><br>
            <button id="openModal">Ajouter une spécialité</button>
            <script src="../js/modal.js"></script>
        </main>
    </section>
    <script src="../js/all.min.js"></script>
    <script src="../js/chart.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
