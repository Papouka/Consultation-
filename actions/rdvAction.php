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

// Récupération des informations du patient
$idpatient = $_SESSION['idpatient']; // Utilisation de l'idpatient de la session
$patient = null;

if ($idpatient) {
    $sql2 = "SELECT nom FROM patient WHERE idpatient = :idpat";
    $stm2 = $pdo->prepare($sql2);
    $stm2->bindParam(":idpat", $idpatient);
    $stm2->execute();
    $patient = $stm2->fetch(PDO::FETCH_ASSOC);
    
    if ($patient) {
        $pat = $patient['nom'];
    } else {
        $msgErreur = "Patient non trouvé.";
    }
} else {
    $msgErreur = "ID du patient manquant.";
}

// Utilisation de la variable $patient
if (isset($patient)) {
    echo "Nom du patient : " . $patient['nom'];
} else {
    echo "Aucune information sur le patient disponible.";
}

// Récupération des créneaux
$stmt = $pdo->prepare("SELECT idcreneau, date, heure_debut, heure_fin FROM creneaux WHERE iddocteur = :iddocteur");
$stmt->execute([':iddocteur' => $iddoc]);
$creneaux = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
