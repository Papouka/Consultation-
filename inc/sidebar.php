<?php
$role = $_SESSION['role'] ?? "administrateur";




echo '<a href="" class="brand"><i class="fas fa-smile icon"></i> LORY</a>
<ul class="side-menu">
    <li><a href="" class="active"><i class="fa fa-dashboard icon" aria-hidden="true"></i> <label for="">Dashboard</label></a></li>
    <li class="divider" data-text="main">Main</li>
    <li>
        <a href=""><i class="fa fa-inbox icon" aria-hidden="true"></i> Consultations<i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
        <ul class="side-dropdown">
            <li><a href="">Alert</a></li>
            <li><a href="">Badges</a></li>
            <li><a href="">Breadcrumbs</a></li>
            <li><a href="">Button</a></li>
        </ul>
    </li>
    <li><a href=""><i class="fas fa-paperclip icon"></i> Ordonnance</a></li>
    <li><a href=""><i class="fas fa-user-astronaut icon"></i> Profil</a></li>
    <li><a href=""><i class="fa fa-table icon" aria-hidden="true"></i> Prise de rendez-vous</a></li>
'; 

if ($role == "docteur") {
    echo '
    <li>
            <a href="pages/table.php"><i class="fas fa-notes-medical icon"></i> Mes patients <i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
            
          </li>';
} else if ($role == "patient") {
    echo '<li>
    
            <a href=""><i class="fas fa-heart icon"></i> Mes Rendez-vous <i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
            <ul class="side-dropdown">
                <li><a href="">Voir mes rendez-vous</a></li>
                <li><a href="">Annuler un rendez-vous</a></li>
            </ul>
          </li>
          <li> <a href=""><i class="fas fa-heart icon"></i> Mon docteur </a>  </li>';
} else if ($role == "administrateur") {
    echo '<li>
            <a href=""><i class="fas fa-cogs icon"></i> Gestion des utilisateurs <i class="fa fa-chevron-right icon-right" aria-hidden="true"></i></a>
            <ul class="side-dropdown">
                <li><a href="">Ajouter un utilisateur</a></li>
                <li><a href="">Modifier un utilisateur</a></li>
                <li><a href="">Supprimer un utilisateur</a></li>
            </ul>
          </li>';
}

?>
