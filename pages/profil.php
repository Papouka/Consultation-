<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .profile-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .profile-header h2 {
            margin: 0;
            font-size: 24px;
        }
        .edit-button {
            background: #25D366;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .edit-button:hover {
            background: #1DAE57;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .save-button {
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }
        .save-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <img id="profileImg" src="default-profile.png" alt="Photo de Profil">
        <div>
            <h2 id="username">Nom d'utilisateur</h2>
            <button class="edit-button" id="editBtn">Modifier</button>
        </div>
    </div>

    <div class="form-group" id="formGroup" style="display: none;">
        <label for="name">Nom :</label>
        <input type="text" id="name" placeholder="Entrez votre nom">

        <label for="imageInput">Changer la photo de profil :</label>
        <input type="file" id="imageInput" accept="image/*">
        
        <button class="save-button" id="saveBtn">Sauvegarder</button>
    </div>
</div>

<script>
    const editBtn = document.getElementById('editBtn');
    const formGroup = document.getElementById('formGroup');
    const username = document.getElementById('username');
    const nameInput = document.getElementById('name');
    const imageInput = document.getElementById('imageInput');
    const profileImg = document.getElementById('profileImg');
    const saveBtn = document.getElementById('saveBtn');

    // Afficher le formulaire de modification
    editBtn.addEventListener('click', () => {
        formGroup.style.display = 'block';
        nameInput.value = username.textContent;
    });

    // Sauvegarder les modifications
    saveBtn.addEventListener('click', () => {
        username.textContent = nameInput.value;

        // Changer la photo de profil si une nouvelle image est sélectionnée
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImg.src = e.target.result; // Mettre à jour l'image de profil
            };
            reader.readAsDataURL(file);
        }

        formGroup.style.display = 'none';
    });
</script>

