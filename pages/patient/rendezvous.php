

<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

// Vérifiez si l'ID du patient est défini
if (!isset($_SESSION['idpatient'])) {
    die("ID du patient non défini dans la session.");
}

require_once("../../inc/connexion.php");

$msgSuccess = '';
$msgErreur = '';

if (isset($_POST['submit'])) {
    if (isset($_POST['iddocteur'], $_POST['idcreneau'], $_POST['motif'])) {
        $iddocteur = $_POST["iddocteur"];
        $idcreneau = $_POST["idcreneau"];
        $motif = $_POST["motif"];
        $idpatient = $_SESSION['idpatient']; // Récupération de l'idpatient

        if (!empty($iddocteur) && !empty($idcreneau) && !empty($motif)) {
            $checkCreneau = $pdo->prepare("SELECT * FROM creneaux WHERE idcreneau = :idcreneau");
            $checkCreneau->bindParam(":idcreneau", $idcreneau);
            $checkCreneau->execute();

            if ($checkCreneau->rowCount() > 0) {
                try {
                    $insert = $pdo->prepare("INSERT INTO rendezvous (iddocteur, idcreneau, idpatient, motif) VALUES (?, ?, ?, ?)");
                    $execute = $insert->execute([$iddocteur, $idcreneau, $idpatient, $motif]);
                    
                    if ($execute) {
                        $msgSuccess = "Rendez-vous programmé avec succès.";
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
    } else {
        $msgErreur = "Erreur dans les données soumises.";
    }
}

// Récupération des informations du docteur
$iddoc = $_GET['iddocteur'] ?? null;
if ($iddoc) {
    $sql1 = "SELECT nom FROM docteur WHERE iddocteur = :iddoc";
    $stm1 = $pdo->prepare($sql1);
    $stm1->bindParam(":iddoc", $iddoc);
    $stm1->execute();
    $docteur = $stm1->fetch(PDO::FETCH_ASSOC);
    $docta = $docteur['nom'] ?? 'Docteur non trouvé';
}



    $idpat = $_SESSION['idpatient']; 

    $sql2 = "SELECT nom FROM patient WHERE idpatient = :idpat";
    $stm2 = $pdo->prepare($sql2);
    $stm2->bindParam(":idpat", $idpat);
    $stm2->execute();
    $patient = $stm2->fetch(PDO::FETCH_ASSOC);
    $nomPatient = $patient['nom'] ?? 'Patient non trouvé';



// Récupération des créneaux
$stmt = $pdo->prepare("SELECT idcreneau, date, heure_debut, heure_fin FROM creneaux WHERE iddocteur = :iddocteur");
$stmt->execute([':iddocteur' => $iddoc]);
$creneaux = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Médicale</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../icons/all.min.css">
    <style>
        .form {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        main {
            padding: 20px;
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

        button {
            background: green;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 25%;
        }
        .radio-button {
        width: 10px; 
        height: 10px; 
        transform: scale(1.5); 
        margin-right: 10px; 
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
    <?php include("../../inc/sidebar4.php"); ?>
</section>
<section id="content">
    <nav>
        <?php include("../../inc/nav4.php"); ?>
    </nav>
    <main>
        <section class="appointment-form">
            <form action="#" method="POST" class="form">
                <h2>Premier rendez-vous avec le Dr. <?php echo htmlspecialchars($docta); ?></h2>

                <div class="form-group">
                    
                    <input type="text" name="iddocteur" value="<?php echo htmlspecialchars($iddoc); ?>" hidden>
                </div>
                <div class="form-group">
                    
                    <input type="text" name="iddocteur" value="<?php echo htmlspecialchars($idpat); ?>" >
                </div>
                <div class="form-group">
    <label for="">Patient:</label>
    <input type="text" name="patient" value="<?php echo htmlspecialchars($nomPatient); ?>" readonly>
</div>


                <div class="form-group">
                    <label for="">Motif:</label>
                    <textarea name="motif" required></textarea>
                </div>
                
                <div >
    <label for="heure">Heure de Rendez-vous:</label>
    <?php foreach ($creneaux as $creneau): ?>
        <input type="radio" class="radio-button" name="idcreneau" value="<?php echo htmlspecialchars($creneau['idcreneau']); ?>" required>
        <?php echo htmlspecialchars($creneau['date'] . ' de ' . $creneau['heure_debut'] . ' à ' . $creneau['heure_fin']); ?><br>
    <?php endforeach; ?>
</div>

                
                <button type="submit" name="submit">Programmer le Rendez-vous</button>
            </form>

            <?php if (!empty($msgSuccess)): ?>
                <div class="success-message"><?php echo htmlspecialchars($msgSuccess); ?></div>
            <?php endif; ?>

            <?php if (!empty($msgErreur)): ?>
                <div class="error-message"><?php echo htmlspecialchars($msgErreur); ?></div>
            <?php endif; ?>
        </section>
    </main>

    <script src="../../js/all.min.js"></script>
    <script src="../../js/script.js"></script>
</body>
</html>
