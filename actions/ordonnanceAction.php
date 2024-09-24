<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$tof = $_SESSION['tof'];
$nom = $_SESSION['nom'];
$idDocteur = $_SESSION['docteur']; // Assurez-vous que l'ID du docteur est stocké dans la session

require_once("../../inc/connexion.php");

// Récupérer la liste des patients
$stmtPatients = $pdo->prepare("SELECT idpatient, nom, dob FROM patient"); // Assurez-vous d'avoir une table patients
$stmtPatients->execute();
$patients = $stmtPatients->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le nom du médecin connecté
$stmtDoctor = $pdo->prepare("SELECT nom FROM docteur WHERE iddocteur = :id"); // Assurez-vous d'avoir une table docteurs
$stmtDoctor->bindParam(':id', $idDocteur, PDO::PARAM_INT);
$stmtDoctor->execute();
$doctor = $stmtDoctor->fetch(PDO::FETCH_ASSOC);

// Traitement du formulaire
$msgSuccess = '';
$msgErreur = '';

if (isset($_POST['submit'])) {
    if (isset($_POST['patient'], $_POST['dob'], $_POST['medicament'], $_POST['dosage'], $_POST['posologie'])) {
        if (!empty($_POST['patient']) && !empty($_POST['dob']) && !empty($_POST['medicament']) && !empty($_POST['dosage']) && !empty($_POST['posologie'])) {
            $patient = $_POST["patient"];
            $dob = $_POST["dob"];
            $medicament = $_POST["medicament"];
            $dosage = $_POST["dosage"];
            $posologie = $_POST["posologie"];
            $docteur = $doctor['nom']; // Utiliser le nom du médecin connecté

            try {
                // Insertion dans la base de données avec statut et is_read
                $insert = $pdo->prepare("INSERT INTO ordonnance (patient, dob, medicament, dosage, posologie, docteur, statut, `read`) VALUES (?, ?, ?, ?, ?, ?, 'nouvelle', FALSE)");
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

                    // Générer le PDF
                    require_once("../../inc/dompdf/autoload.inc.php");
                    $dompdf = new Dompdf\Dompdf();
                    $dompdf->loadHtml(viewOrdonnance($ordonnanceDetails));
                    $dompdf->setPaper('A4', 'portrait'); // Définir le format de papier
                    $dompdf->render();
                    $dompdf->stream("ordonnance.pdf", ["Attachment" => false]); // Affiche le PDF dans le navigateur

                } else {
                    $msgErreur = "Échec de l'insertion de l'ordonnance.";
                    $errorInfo = $insert->errorInfo();
                    echo "Erreur SQL: " . htmlspecialchars($errorInfo[2]); // Afficher l'erreur SQL
                }
            } catch (PDOException $e) {
                $msgErreur = "Erreur: " . htmlspecialchars($e->getMessage());
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}

// Fonction pour générer le contenu HTML de l'ordonnance
function viewOrdonnance($ordonnanceDetails) {
    $html = '<h1>Ordonnance médicale</h1>';
    $html .= '<p>Nom du patient : ' . htmlspecialchars($ordonnanceDetails['patient']) . '</p>';
    $html .= '<p>Date de naissance : ' . htmlspecialchars($ordonnanceDetails['dob']) . '</p>';
    $html .= '<p>Médicament : ' . htmlspecialchars($ordonnanceDetails['medicament']) . '</p>';
    $html .= '<p>Dosage : ' . htmlspecialchars($ordonnanceDetails['dosage']) . '</p>';
    $html .= '<p>Posologie : ' . htmlspecialchars($ordonnanceDetails['posologie']) . '</p>';
    $html .= '<p>Docteur : ' . htmlspecialchars($ordonnanceDetails['docteur']) . '</p>';
    $html .= '<p>Date : ' . htmlspecialchars($ordonnanceDetails['date']) . '</p>';
    return $html;
}

// Affichage des messages
if (!empty($msgSuccess)) {
    echo "<div class='success'>$msgSuccess</div>";
}
if (!empty($msgErreur)) {
    echo "<div class='error'>$msgErreur</div>";
}
?>