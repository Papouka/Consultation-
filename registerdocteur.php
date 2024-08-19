<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$msgErreur = ""; // Initialisation de la variable d'erreur

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Traitement du formulaire
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['email'], $_FILES['tof'], $_FILES['cni'], $_POST['specialite'], $_POST['grade'], $_FILES['diplome'], $_FILES['certificat'], $_POST['mdp'])) {
        if ($_POST['nom'] != "" && $_POST['prenom'] != "" && $_POST['tel'] != "" && $_POST['email'] != "" && $_POST['specialite'] != "" && $_POST['grade'] != "" && $_POST['mdp'] != "") {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            $specialite = $_POST["specialite"];
            $grade = $_POST["grade"];
            $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT); // Crypter le mot de passe

            
            // Gestion des fichiers
            $cniPath = $tofPath = $diplomePath = $certificatPath = null;

            if ($_FILES['cni']['error'] == UPLOAD_ERR_OK) {
                $cniPath = 'img/' . basename($_FILES['cni']['name']);
                move_uploaded_file($_FILES['cni']['tmp_name'], $cniPath);
            } else {
                $msgErreur = "Erreur lors du téléchargement de la CNI.";
            }

            if ($_FILES['tof']['error'] == UPLOAD_ERR_OK) {
                $tofPath = 'img/' . basename($_FILES['tof']['name']);
                move_uploaded_file($_FILES['tof']['tmp_name'], $tofPath);
            } else {
                $msgErreur = "Erreur lors du téléchargement de la photo de profil.";
            }

            if ($_FILES['diplome']['error'] == UPLOAD_ERR_OK) {
                $diplomePath = 'img/' . basename($_FILES['diplome']['name']);
                move_uploaded_file($_FILES['diplome']['tmp_name'], $diplomePath);
            } else {
                $msgErreur = "Erreur lors du téléchargement du diplôme.";
            }

            if ($_FILES['certificat']['error'] == UPLOAD_ERR_OK) {
                $certificatPath = 'img/' . basename($_FILES['certificat']['name']);
                move_uploaded_file($_FILES['certificat']['tmp_name'], $certificatPath);
            } else {
                $msgErreur = "Erreur lors du téléchargement du certificat.";
            }

            // Vérification de l'email
            $sql = "SELECT * FROM docteur WHERE email=?";
            $stm = $pdo->prepare($sql);
            $stm->execute(array($email));
            if ($stm->rowCount() > 0) {
                echo "Cette adresse e-mail est déjà utilisée.";
            } else {
                // Vérification des champs requis
                if (!empty($nom) && !empty($prenom) && !empty($tel) && !empty($email) && 
                    !empty($specialite) && !empty($grade) && 
                    !empty($tofPath) && !empty($cniPath) && 
                    !empty($diplomePath) && !empty($certificatPath) ) {
                    
                    try {
                        $insert = $pdo->prepare("INSERT INTO docteur (nom, prenom, tel, email, tof, cni, specialite, grade, diplome, certificat, mdp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $execute = $insert->execute([$nom, $prenom, $tel, $email, $tofPath, $cniPath, $specialite, $grade, $diplomePath, $certificatPath, $mdp]);
                        $_SESSION['nom'] = $nom;
                        $_SESSION['tof'] = $tofPath;
                        header("Location: pages/accueil.php");
                        exit();
                    } catch (PDOException $e) {
                        $msgErreur = "Erreur: " . $e->getMessage();
                    }
                } else {
                    $msgErreur = "Tous les champs sont requis.";
                }
            }
        } else {
            $msgErreur = "Tous les champs sont requis.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, in itial-scale=1.0">
    <link rel="stylesheet" href="icons/all.min.css">
    <script src="js/all.min.js"></script>
    <link rel="stylesheet" href="css/patient.css">
    <link rel="stylesheet" href="css/index.css">
    
    <title>Document</title>
</head>
<body>
    
<header>
<?php include("inc/header.php"); ?>
    </header>


    <div id="page" class="site">
        <div class="contain">
            <div class="form-box">
                <div class="progress">
                    <div class="logo"><a href=""><span>LO</span>RY</a></div>
                    <ul class="progress-steps">
                        <li class="step"><span>1</span><p>Informations personnelles <br></p></li>
                        <li class="step"><span>2</span><p>Document requis <br></p></li>
                    </ul>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form one form-step active">
                        <h2>Entrer vos informations personnelles</h2>
                        <div>
                            <label for="">Nom</label>
                            <input type="text" name="nom" placeholder="Votre nom" required>
                        </div> 
                        <div>
                            <label for="">Prénom</label>
                            <input type="text" name="prenom" placeholder="Votre prénom" required>
                        </div>
                        <div>
                            <label for="">Numéro de téléphone</label>
                            <input type="tel" name="tel" placeholder="Votre numéro de téléphone" required>
                        </div>
                        <div>
                            <label for="">Email</label>
                            <input type="email" name="email" placeholder="Votre email" required>
                        </div>
                        <div>
                            <label>Copie de la CNI</label>
                            <input type="file" id="imageUpload" name="cni" accept="image/*" required>
                        </div><br>
                    </div>
                    
                    <div class="form-two form-step active">
                        <h2>Document requis</h2>
                        
                        <div>
                            <label>Votre photo de profil</label>
                            <input type="file" id="imageUpload" name="tof" accept="image/*" required>
                        </div><br>
                        <div>
                            <label>Spécialité</label>
                            <input type="text" name="specialite" required>
                        </div>
                        <div><br>
                            <label>Votre grade</label>
                            <input type="text" name="grade" required>
                        </div><br>
                        <div>
                            <label for="">Diplôme de docteur en médecine</label>
                            <input type="file" name="diplome" accept="image/*" required>
                        </div><br>
                        <div>
                            <label>Certificats de spécialisation</label>
                            <input type="file" id="imageUpload" name="certificat" accept="image/*" required> 
                        </div><br>
                        <div>
                            <label>Mot de passe</label>
                            <input type="password" name="mdp" placeholder="Votre mot de passe" required>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn-prev" disabled>PRÉCÉDENT</button>
                        <button type="button" class="btn-next">SUIVANT</button>
                        <button type="submit" name="submit" class="btn-submit" style="display:none;">ENVOYER</button>
                    </div>
                </form>
                
                <?php if ($msgErreur): ?>
                    <div class="error-message"><?php echo $msgErreur; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<footer>
<?php include("inc/footer.php"); ?>
</footer>

<script src="js/accueil.js"></script>
<script>
    const nextButton = document.querySelector('.btn-next');
    const prevButton = document.querySelector('.btn-prev');
    const steps = document.querySelectorAll('.step');
    const forms = document.querySelectorAll('.form-step');
    const submitButton = document.querySelector('.btn-submit');
    let active = 1;

    nextButton.addEventListener('click', () => {
        if (active < steps.length) {
            active++;
            updateProgress();
        }
    });

    prevButton.addEventListener('click', () => {
        if (active > 1) {
            active--;
            updateProgress();
        }
    });

    const updateProgress = () => {
        steps.forEach((step, i) => {
            step.classList.toggle('active', i === (active - 1));
        });

        forms.forEach((form, i) => {
            form.classList.toggle('active', i === (active - 1));
        });

        prevButton.disabled = active === 1;
        nextButton.style.display = active === steps.length ? 'none' : 'inline-block';
        submitButton.style.display = active === steps.length ? 'inline-block' : 'none';
    };

    updateProgress();
    </script>
</body>
</html>
    
    
    
