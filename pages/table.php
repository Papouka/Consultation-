<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTable des Patients</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../icons/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            align-items: center;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: hsl(158, 97%, 39%);
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            border-radius: 50%;
        }
        .dataTables_wrapper {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<main>
<h1>Liste des Patients</h1>

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

                $sql = "SELECT idpatient, nom, prenom, tel, tof, email FROM patient";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
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
</main>
<script src="../js/all.min.js"></script>
<script src="../js/script.js"></script>
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
