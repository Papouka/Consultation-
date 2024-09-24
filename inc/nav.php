<i class='bx bx-menu toggle-sidebar'><i class="fa-solid fa-bars" aria-hidden="true"></i></i>

<form action="conference.php" method="POST"> 
    <div class="form-group">
        <input type="text" name="lien" placeholder="Entrez le lien........"> 
        <button type="submit" name="save"><i class="fa-solid fa-video icon" aria-hidden="true"></i></button>
    </div>
</form>




<a href="javascript:void(0);" class="nav-link" id="notification-link">
    <i class="fa fa-bell icon" aria-hidden="true"></i>
    <span class="badge"  id="notification-count"><?php echo $nbre; ?></span> 
    <div id="notification-list" style="display: none;">
     <ul>
     <?php foreach ($stmt1 as $rdv): ?>
    <a href="../pages/docteur/priserendezvous.php?idpatient=<?php echo htmlspecialchars($rdv['idpatient']); ?>">
        <li><?php echo htmlspecialchars($rdv['motif']); ?></li>
    </a>
<?php endforeach; ?>

        </ul>
</div>
</a>
<a href="" class="nav-link">
    <i class="fa fa-envelope icon" aria-hidden="true"></i>
    <span class="badge">8</span>
</a>
<span class="divider"></span>
<div class="profile">

    <img src="../<?php echo htmlspecialchars($tof); ?>" alt="">
    hey
    <?php echo htmlspecialchars($nom); ?>
    <ul class="profile-link">
        <li><a href="pages/profil.php"><i class="fa fa-user-circle" aria-hidden="true"></i> profile</a></li>
        <li><a href=""><i class="fa fa-gear" aria-hidden="true"></i> paramètre</a></li>
        <li>
            <form action="../logout.php" method="POST"> 
                <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;">
                    <i class="fa fa-power-off" aria-hidden="true"></i> se déconnecter
                </button>
            </form>
        </li>
    </ul>
</div>


<script>
    // Afficher ou masquer la liste de notifications au clic sur l'icône
    document.getElementById('notification-link').onclick = function() {
        var notificationList = document.getElementById('notification-list');
        notificationList.style.display = (notificationList.style.display === 'none') ? 'block' : 'none';
    };

    // Masquer la notification et décrémenter le compteur lorsqu'on clique sur un élément de la liste
    var notificationItems = document.querySelectorAll('.notification-item');
    notificationItems.forEach(function(item) {
        item.onclick = function() {
            var notificationList = document.getElementById('notification-list');
            notificationList.style.display = 'none'; // Masquer la liste après le clic
            
            // Décrémenter le compteur de notifications
            var notificationCount = document.getElementById('notification-count');
            notificationCount.textContent = parseInt(notificationCount.textContent) - 1;

            // Optionnel : Marquer la notification comme lue dans la base de données
            var idRendezvous = item.getAttribute('data-id');
            fetch('mark_as_read.php?id=' + idRendezvous); // Appel à un script pour mettre à jour le statut
        };
    });
</script>