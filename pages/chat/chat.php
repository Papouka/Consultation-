<?php


$role = $_SESSION['role'] ?? "administrateur";

if ($role == "docteur") {
    echo ''; 
} else if ($role == "patient") {
    echo ''; 
} else if ($role == "administrateur") {
    echo '<div class="chat-box">
            <p class="day"><span>Aujourd\'hui</span></p>
            <div class="msg">
                <img src="path/to/profile-image.jpg" alt="Profile Image" class="profile-img">
                <div class="chat">
                    <div class="profile">
                        <span class="username">Lory</span>
                        <span class="heure">18:30</span>
                    </div>
                    <p>Salut</p>
                </div>
            </div>';

    // Exemple de messages
    $messages = [
        ["user" => "Vous", "time" => "18:31", "text" => "Bonjour! Comment ça va?"],
        ["user" => "Lory", "time" => "18:32", "text" => "Ça va bien, merci!"],
        ["user" => "Vous", "time" => "18:33", "text" => "Super!"],
    ];

    foreach ($messages as $msg) {
        echo '<div class="msg ' . ($msg['user'] === 'Vous' ? 'me' : '') . '">
                <div class="chat">
                    <div class="profile">
                        <span class="heure">' . htmlspecialchars($msg['time']) . '</span>
                    </div>
                    <p>' . htmlspecialchars($msg['text']) . '</p>
                </div>
            </div>';
    }

    echo '    </div> 
                <form action="send_message.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="message" id="message" placeholder="Tapez votre message..." required>
                        <button type="submit" class="btn-send"><i class="bx bxs-send"></i></button>
                    </div>
                </form>
            </div>';
}
?>
