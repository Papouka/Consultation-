<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];
$idpatient = $_SESSION['idpatient']; 

require_once("../../inc/connexion.php");

$msgSuccess = '';
$msgErreur = '';

if (isset($_POST['submit'])) {
    if (isset($_POST['iddocteur'], $_POST['idcreneau'], $_POST['motif'])) {
        $iddocteur = $_POST["iddocteur"];
        $idcreneau = $_POST["idcreneau"];
        $motif = $_POST["motif"];

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
    $docta = $docteur['nom'] ;
}

// Récupération des informations du patient
$sql2 = "SELECT nom FROM patient WHERE idpatient = :idpat";
$stm2 = $pdo->prepare($sql2);
$stm2->bindParam(":idpat", $idpatient);
$stm2->execute();
$patient = $stm2->fetch(PDO::FETCH_ASSOC);
$pat = $patient['nom'] ;

// Récupération des créneaux
$stmt = $pdo->prepare("SELECT idcreneau, date, heure_debut, heure_fin FROM creneaux WHERE iddocteur = :iddocteur");
$stmt->execute([':iddocteur' => $iddoc]);
$creneaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
