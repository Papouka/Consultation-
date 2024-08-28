<?php
session_start();

if (!isset($_SESSION['email'])) {
   header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
$iddocteur = $_SESSION['iddocteur'];

?>

<!DOCTYPE html>
<html lang="fr"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCUEIL</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <?php include("../../inc/csslistepatient.php"); ?>
</head>

<body>
    <section id="sidebar">
        <?php include("../../inc/sidebar2.php"); ?>
    </section>
    <section id="content">
        <nav>
            <?php include("../../inc/nav2.php"); ?>
        </nav>
        <main>
            <h1 class="title">Dashboard</h1>
             
            <ul class="breadcrumbs">
                <li><a href="index.php">Accueil</a></li> 
                <li class="divider">/</li>
                <li><a href="" class="active">Dashboard</a></li>
            </ul>
            <div class="info-data">
            <div class="table-container">
    <table id="userTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de téléphone</th>
                <th>Photo de Profil</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT *
                        FROM patient 
                         JOIN rendezvous ON patient.idpatient = rendezvous.idpatient 
                        ";
                
                $stmt = $pdo->prepare($sql);
                $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($patients) {
                    foreach ($patients as $utilisateur) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($utilisateur["idpatient"]) . "</td>";
                        echo "<td>" . htmlspecialchars($utilisateur["nom"]) . "</td>";
                        echo "<td>" . htmlspecialchars($utilisateur["prenom"]) . "</td>";
                        echo "<td>" . htmlspecialchars($utilisateur["tel"]) . "</td>";
                        echo "<td><img src='" . htmlspecialchars($utilisateur["tof"]) . "' alt='" . htmlspecialchars($utilisateur["nom"]) . "' width='50'></td>";
                        echo "<td>" . htmlspecialchars($utilisateur["email"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Aucun patient trouvé</td></tr>";
                }
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
            ?>
        </tbody>
    </table>
</div>
            </div>
            <div class="data">
                
            </div>   
        </main>
    </section>
    <script src="../../js/all.min.js"></script>
    <script src="../../js/chart.js"></script>
    <script src="../../js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "language": {
                "lengthMenu": "Afficher _MENU_ patients par page",
                "zeroRecords": "Aucun patient trouvé",
                "info": "Affichage de la page _PAGE_ sur _PAGES_",
                "infoEmpty": "Aucun patient disponible",
                "infoFiltered": "(filtré de _MAX_ patients)",
                "search": "Rechercher:",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            }
        });
    });
</script>

</body>
</html>
