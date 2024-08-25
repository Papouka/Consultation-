<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof']; 
$nom = $_SESSION['nom'];

require_once("../../inc/connexion.php");

// Traitement du formulaire
$msgSuccess = '';
$msgErreur = '';

if (isset($_POST['submit'])) {
    if (isset($_POST['patient'], $_POST['dob'], $_POST['medicament'], $_POST['dosage'], $_POST['posologie'], $_POST['docteur'])) {
        if (!empty($_POST['patient']) && !empty($_POST['dob']) && !empty($_POST['medicament']) && !empty($_POST['dosage']) && !empty($_POST['posologie']) && !empty($_POST['docteur'])) {
            $patient = $_POST["patient"];
            $dob = $_POST["dob"];
            $medicament = $_POST["medicament"];
            $dosage = $_POST["dosage"];
            $posologie = $_POST["posologie"];
            $docteur = $_POST["docteur"];

            try {
                // Insertion dans la base de données
                $insert = $pdo->prepare("INSERT INTO ordonnance (patient, dob, medicament, dosage, posologie, docteur) VALUES (?, ?, ?, ?, ?, ?)");
                $execute = $insert->execute([$patient, $dob, $medicament, $dosage, $posologie, $docteur]);

                if ($execute) {
                    $msgSuccess = "L'ordonnance a été créée avec succès.";
                    $ordonnanceDetails = [
                        'patient' => $patient,
                        'dob' => $dob,
                        'medicament' => $medicament,
                        'dosage' => $dosage,
                        'posologie' => $posologie,
                        'docteur' => $docteur,
                        'date' => date('Y-m-d')
                    ];
                } else {
                    $msgErreur = "Échec de l'insertion de l'ordonnance.";
                    $errorInfo = $insert->errorInfo();
                    echo "Erreur SQL: " . $errorInfo[2]; // Afficher l'erreur SQL
                }
            } catch (PDOException $e) {
                $msgErreur = "Erreur: " . $e->getMessage();
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}

?>