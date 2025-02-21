<?php
session_start();

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!isset($_SESSION['patient'])) {
    die("Erreur: ID du patient non défini dans la session.");
}

require_once("../../inc/vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$idpatient = $_SESSION['patient'];
$medecins = [];
$msgSuccess = '';
$msgErreur = '';

try {
    $stmt = $pdo->prepare("SELECT DISTINCT d.* FROM docteur d 
                            JOIN rendezvous r ON d.iddocteur = r.iddocteur");
    $stmt->execute();
    $medecins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $msgErreur = "Erreur lors de la récupération des médecins: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $iddocteur = $_POST["iddocteur"] ?? null;
    $idcreneau = $_POST["idcreneau"] ?? null;
    $motif = $_POST["motif"] ?? null;

    if (!empty($iddocteur) && !empty($idcreneau) && !empty($motif)) {
        $checkCreneau = $pdo->prepare("SELECT * FROM creneaux WHERE idcreneau = :idcreneau");
        $checkCreneau->bindParam(":idcreneau", $idcreneau);
        $checkCreneau->execute();

        if ($checkCreneau->rowCount() > 0) {
            try {
                $insert = $pdo->prepare("INSERT INTO rendezvous (iddocteur, idcreneau, idpatient, motif) VALUES (?, ?, ?, ?)");
                $execute = $insert->execute([$iddocteur, $idcreneau, $idpatient, $motif]);

                if ($execute) {
                    // Récupération des informations du docteur pour l'email
                    $sql1 = "SELECT email, nom FROM docteur WHERE iddocteur = :iddoc";
                    $stm1 = $pdo->prepare($sql1);
                    $stm1->bindParam(":iddoc", $iddocteur);
                    $stm1->execute();
                    $docteur = $stm1->fetch(PDO::FETCH_ASSOC);

                    // Configuration de PHPMailer
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'papoukalory@gmail.com';
                        $mail->Password = 'orjqyjacvgvpowxp'; 
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->setFrom('papoukalory@gmail.com', 'Lory');
                        $mail->addAddress($docteur['email'], $docteur['nom']);

                        // Contenu de l'email
                        $mail->isHTML(true);
                        $mail->Subject = 'Nouvelle demande de consultation';
                        $link = "http://localhost/easydoctor/pages/docteur/priserendezvous.php";
                        $mail->Body = "Bonjour Dr. " . htmlspecialchars($docteur['nom']) . ",<br><br>" .
                                      "Vous avez reçu une nouvelle demande de rendez-vous.<br>" .
                                      "Patient: " . htmlspecialchars($nom) . "<br>" .
                                      "Motif: " . htmlspecialchars($motif) . "<br>" .
                                      "Pour accepter ou refuser cette demande, veuillez cliquer sur le lien suivant: <a href='" . $link . "'>Accepter ou Refuser le Rendez-vous</a>";

                        $mail->send();
                        $msgSuccess = "Rendez-vous programmé avec succès. Un email a été envoyé au docteur.";
                    } catch (Exception $e) {
                        $msgErreur = "Rendez-vous programmé, mais échec de l'envoi de l'email au docteur. Erreur: {$mail->ErrorInfo}";
                    }
                } else {
                    $msgErreur = "Échec de la programmation du rendez-vous.";
                }
            } catch (PDOException $e) {
                $msgErreur = "Erreur: " . $e->getMessage();
            }
        } else {
            $msgErreur = "Le créneau sélectionné n'existe pas.";
        }
    } else {
        $msgErreur = "Tous les champs sont requis.";
    }
}

$idpat = $_SESSION['patient']; 
$sql2 = "SELECT nom FROM patient WHERE idpatient = :idpat";
$stm2 = $pdo->prepare($sql2);
$stm2->bindParam(":idpat", $idpat);
$stm2->execute();
$patient = $stm2->fetch(PDO::FETCH_ASSOC);
$nomPatient = $patient['nom'] ?? 'Patient non trouvé';

$creneaux = ''; 

if (isset($_GET['iddocteur'])) {
    $iddocteur = $_GET['iddocteur'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM creneaux WHERE iddocteur = :iddocteur");
        $stmt->bindParam(':iddocteur', $iddocteur);
        $stmt->execute();
        $creneaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($creneaux as $creneau) {
            echo '<input type="radio" name="idcreneau" value="' . htmlspecialchars($creneau['idcreneau']) . '" required>';
            echo htmlspecialchars($creneau['date'] . ' de ' . $creneau['heure_debut'] . ' à ' . $creneau['heure_fin']) . '<br>';
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Médecins</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
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
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 50%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .form {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-group {
            margin-bottom: 15px;
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button {
            background: green;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 34%;
        }
        .success-message, .error-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            text-underline-position: top;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<section id="sidebar">
    <?php include("../../inc/sidebar2.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav2.php"); ?>
    </nav>

    <h1>Liste des Médecins</h1>

    <?php if (!empty($medecins)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nom du Médecin</th>
                    <th>Spécialité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medecins as $medecin): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($medecin['nom']); ?></td>
                        <td><?php echo htmlspecialchars($medecin['idspecialiste']); ?></td>
                        <td>
                            <a href="#" class="open-modal" data-id="<?php echo $medecin['iddocteur']; ?>" data-nom="<?php echo htmlspecialchars($medecin['nom']); ?>">Prendre Rendez-vous</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun médecin trouvé pour ce patient.</p>
    <?php endif; ?>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modal-title">rendez-vous avec le Dr. </h2> 

            <div id="modal-body">
                <form action="#" method="POST" class="form">
                    <input type="hidden" name="iddocteur" id="iddocteur" value="">
                    <input type="hidden" name="idpatient" value="<?php echo $_SESSION['patient']; ?>" readonly>

                    <div class="form-group">
                        <label for="">Patient:</label>
                        <input type="text" name="patient" value="<?php echo htmlspecialchars($nomPatient); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Motif:</label>
                        <textarea name="motif" required></textarea>
                    </div>
                    
                    <div>
                        <label for="heure">Heure de Rendez-vous:</label>
                        <div id="creneaux-container">
                            <!-- Les créneaux horaires seront chargés ici -->
                        </div>
                    </div>

                    <button class="button" type="submit" name="submit">Envoyer la demande de Rendez-vous</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../../js/all.min.js"></script>
    <script src="../../js/script.js"></script>
    <script>
        // Ouvrir la modal
        document.querySelectorAll('.open-modal').forEach(function(element) {
            element.onclick = function(event) {
                event.preventDefault();
                var doctorId = this.getAttribute('data-id');
                var doctorName = this.getAttribute('data-nom'); // Récupérer le nom du docteur
                document.getElementById('modal-title').innerText = "Premier rendez-vous avec le Dr. " + doctorName; // Mettre à jour le titre
                document.getElementById('iddocteur').value = doctorId; // Mettre à jour l'ID du docteur
                loadModalContent(doctorId); // Charger le contenu de la modal
                document.getElementById('myModal').style.display = "block";
            };
        });

        // Fermer la modal
        document.querySelector('.close').onclick = function() {
            document.getElementById('myModal').style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                document.getElementById('myModal').style.display = "none";
            }
        };

        // Charger le contenu de la modal
        function loadModalContent(doctorId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?iddocteur=' + doctorId, true); // Appel à la même page
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('creneaux-container').innerHTML = this.responseText; // Mettre à jour le contenu
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
