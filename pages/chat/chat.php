
<?php

$_SESSION['iddocteur'] = 16;
$_SESSION['idpatient'] = 26; 

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!isset($_SESSION['iddocteur']) || !isset($_SESSION['idpatient'])) {
   
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iddocteur = $_SESSION['iddocteur'];
    $idpatient = $_SESSION['idpatient'];
    $message = trim($_POST['message']);
    if (empty($message)) {
        die("Erreur : Le message ne peut pas être vide.");
    }
    // Vérifiez si l'iddocteur existe
    $stmt = $pdo->prepare("SELECT * FROM docteur WHERE iddocteur = :iddocteur");
    $stmt->bindParam(':iddocteur', $iddocteur);
    $stmt->execute();
    if ($stmt->rowCount() === 0) {
        die("Erreur : L'ID du docteur n'existe pas.");
    }
    try {
        $stmt = $pdo->prepare("INSERT INTO message (idpatient, iddocteur, message, dateenvoie) VALUES (:idpatient, :iddocteur, :message, NOW())");
        $stmt->bindParam(':idpatient', $idpatient);
        $stmt->bindParam(':iddocteur', $iddocteur);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'envoi du message : " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Consultations</title>
</head>
<body>
<div class="chat-box">
    <p class="day"><span>Aujourd'hui</span></p>
    <?php
       try {
        $stmt = $pdo->prepare("SELECT * FROM message WHERE idpatient = :idpatient AND iddocteur = :iddocteur ORDER BY dateenvoie DESC");
        $stmt->bindParam(':idpatient', $_SESSION['idpatient']);
        $stmt->bindParam(':iddocteur', $_SESSION['iddocteur']);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($messages) {
            foreach ($messages as $msg) {
                echo "<div><strong>Vous :</strong> " . htmlspecialchars($msg['message']) . " <em>(" . htmlspecialchars($msg['dateenvoie']) . ")</em></div>";
            }
        } else {
            echo "<p>Aucun message échangé pour le moment.</p>";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des messages : " . $e->getMessage();
    }
        
        ?>
    <div id="messages"></div>

    <form id="chat-form" action="accueil.php" method="POST">
        <div class="form-group">
            <input type="text" name="message" id="message" placeholder="Tapez votre message..." required>
            <button type="submit" class="btn-send"><i class="bx bxs-send"></i></button>
        </div>
    </form>

       
       
    </div>
</body>
</html>
