<?php
$role = $_SESSION['role'] ?? "administrateur";
?>
 <ul>
 <li>
    <a href="../index.php"><span class="span">Easy</span>doctor</a>
    </li> <br><br>
 </ul>

<ul class="side-menu">

    <li><a href="" class="active"><i class="fa fa-dashboard icon" aria-hidden="true"></i> <label for="">Dashboard</label></a></li>
    <li class="divider" data-text="main">Main</li>
    
   
    <li><a href="../pages/patient/profil.php"><i class="fas fa-user-astronaut icon"></i> Profil</a></li>
    <li><a href=""> <i class="fa-solid fa-message icon"></i> Mes conversations</a></li>
    <style>
        
.span {
    background-color: hsl(158, 97%, 29%);
    color: aliceblue;
    padding: 0px 5px;
    border-radius: 5px;
    font-weight: 600;
    margin-right: 5px;
}
li{
  list-style-type: none;
}
a{
    color: black;
}
    </style>
<?php

if ($role == "docteur") {
?>
<li>
<a href="../pages/docteur/listepatient.php"><i class="fa fa-inbox icon" aria-hidden="true"></i>Dossiers medicaux<i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
       
    </li>
    
    <li><a href="../pages/docteur/resultat.php"><i class="fa-solid fa-print icon"></i>Envoies des examens</a></li>
    <li><a href="../pages/docteur/programmer.php"><i class="fa-solid fa-print icon"></i>conférence</a></li>
    <li><a href="../pages/patient/ordonnance.php"><i class="fas fa-paperclip icon"></i> Ordonnance</a></li>
    <li><a href="../pages/docteur/creneaux.php"><i class="fa-solid fa-business-time icon"></i> Mes creneaux horaires</a></li>
    <li><a href="../pages/docteur/priserendezvous.php"><i class="fa fa-table icon" aria-hidden="true"></i> Mes rendez-vous</a></li>
    <li>
            <a href="../pages/docteur/mespatients.php"><i class="fas fa-notes-medical icon"></i> Mes patients <i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
            
          </li>

<?php } else if ($role == "patient") {?>
    
    <li>
        <a href="../pages/patient/consultation.php"><i class="fa fa-inbox icon" aria-hidden="true"></i>Voir mes consultations<i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
       
    </li>
    <li><a href="../pages/patient/prendre.php"><i class="fa fa-table icon" aria-hidden="true"></i>Prendre rendez-vous</a></li>
    <li><a href="../pages/patient/rendezvous.php"><i class="fa fa-table icon" aria-hidden="true"></i> Demande de rendez-vous</a></li>
 
          <li> <a href="../pages/patient/mondocteur.php"><i class="fa-solid fa-user-doctor icon"></i> Mon docteur </a>  </li>
          <li> <a href="../pages/patient/dossier.php"><i class="fa-regular fa-folder-open icon"></i> Mon dossier medical </a>  </li>
          
<?php } else if ($role == "administrateur") {?>
    <li>
        <a href=""><i class="fa fa-inbox icon" aria-hidden="true"></i> Consultations<i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
       
    </li>
<li>
<li><a href=""><i class="fa fa-table icon" aria-hidden="true"></i> Prise de rendez-vous</a></li>
            <a href=""><i class="fas fa-cogs icon"></i> Gestion des utilisateurs <i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
            <ul class="side-dropdown">
                <li><a href="">Ajouter un utilisateur</a></li>
                <li><a href="">Modifier un utilisateur</a></li>
                <li><a href="">Supprimer un utilisateur</a></li>
            </ul>
          </li>';
<?php }

?>
