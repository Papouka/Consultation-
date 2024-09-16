
<?php
$_SESSION['iddocteur'] = 16; // Assurez-vous que cette variable est définie lors de la connexion
$_SESSION['idpatient'] = 27; // Assurez-vous que cette variable est définie lors de la connexion

// Vérifiez que les variables de session sont définies
if (!isset($_SESSION['iddocteur']) || !isset($_SESSION['idpatient'])) {
    die("Erreur : Identifiants manquants.");
}

// Récupération des IDs depuis les variables de session
$iddocteur = $_SESSION['iddocteur'];
$idpatient = $_SESSION['idpatient'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le message depuis la requête POST
    $message = trim($_POST['message']);

    // Vérifiez que le message n'est pas vide
    if (empty($message)) {
        die("Erreur : Le message ne peut pas être vide.");
    }

    // Déterminer l'auteur du message
    $auteur = (isset($_SESSION['role']) && $_SESSION['role'] === 'docteur') ? 'docteur' : 'patient';

    try {
        // Insertion du message
        $stmt = $pdo->prepare("INSERT INTO message (idpatient, iddocteur, message, dateenvoie, auteur) VALUES (:idpatient, :iddocteur, :message, NOW(), :auteur)");
        $stmt->bindParam(':idpatient', $idpatient);
        $stmt->bindParam(':iddocteur', $iddocteur);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->execute();
        echo "Message envoyé!";
    } catch (PDOException $e) {
        echo "Erreur lors de l'envoi du message : " . $e->getMessage();
    }
    exit();
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Consultations</title>
    
    <script src="(link unavailable)"></script>
    <style>
      

        
      .chat-container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
           
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .chat-header { 
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .chat-messages {
            padding: 15px;
            max-height: 300px;
            overflow-y: auto;
           
        }

        .chat-footer {
            padding: 10px;
            display: flex;
        }

        .chat-footer input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .chat-footer button {
            padding: 10px;
            background-color:#4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-footer button:hover {
            background-color: #0056b3;
        }
       
        .form input{
           border: none;
            background: rgb(236, 233, 233);
            border-radius: 5px;
            transition: all .3s ease;
            box-shadow: 0 0 0 1px green, 0 0 0 4px lightgreen;
        }
        .message-sent {
            background-color: #e1ffc7;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: right;
            max-width: 70%;
            margin-left: auto;
        }

        .message-received {
            background-color: #f1f0f0;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: left;
            max-width: 70%;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        
        <div class="chat-messages">
            <?php include 'realTimeChat.php'; ?>
        </div>
        <div class="form">
        <div class="chat-footer">
        <form id="chat-form" action="#" method="POST">
    <input type="hidden" name="auteur" value="docteur"> 
    <input type="text" name="message" id="message" placeholder="Tapez votre message...">
    <button type="submit" class="send" id="send"> <i class="fa fa-paper-plane-o" aria-hidden="true"></i> </button>
</form>
</div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            // Déterminez l'auteur connecté (vous devez définir `userRole` selon l'utilisateur)
            var userRole = 'patient'; // ou 'docteur'
            $("#chat-form").on("submit", function(e) {
                e.preventDefault();
                // Envoyer le message au serveur
                $.ajax({
                    url: "",
                    method: "POST",
                    data: {
                        message: $("#message").val(""),
                        auteur: userRole
                    },
                    success: function(data) {
                        $("#message").val("");
                        // Mettre à jour les messages en temps réel
                        $.ajax({
                            url: "realTimeChat.php",
                            method: "POST",
                            success: function(data) {
                                $(".chat-messages").html(data);
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

