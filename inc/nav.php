<i class='bx bx-menu toggle-sidebar'><i class="fa-solid fa-bars" aria-hidden="true"></i></i>

<form action="">
    <div class="form-group">
        <input type="text" placeholder="recherchez.....">
        <i class="fa fa-search icon" aria-hidden="true"></i>
    </div>
</form>
<a href="" class="nav-link">
    <i class="fa fa-bell icon" aria-hidden="true"></i>
    <span class="badge">5</span>
</a>
<a href="" class="nav-link">
    <i class="fa fa-envelope icon" aria-hidden="true"></i>
    <span class="badge">8</span>
</a>
<span class="divider"></span>
<div class="profile">

    <img src="<?php echo htmlspecialchars($tof); ?>" alt="">
    hey
    <?php   echo htmlspecialchars($nom); ?>
    <ul class="profile-link">
        <li><a href="pages/profil.php"><i class="fa fa-user-circle" aria-hidden="true"></i> profile</a></li>
        <li><a href=""><i class="fa fa-gear" aria-hidden="true"></i> paramètre</a></li>
        <form action="" method="POST">
        <li><a href="../logout.php"> <i class="fa fa-power-off" aria-hidden="true"></i> se deconnecter</a></li>
        </form>
    </ul>
</div>