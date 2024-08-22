<a href="#" class="logo"> <span>Easy</span>doctor</a>
<ul class="navbar" id="navbar">
    <?php if (isset($specialiste) && is_array($specialiste)): ?>
        <?php foreach ($specialiste as $specialiste): ?>
            <li>
            <a href="pages/specialiste.php?idspecialiste=<?php echo htmlspecialchars($specialiste['idspecialiste']); ?>">
                <?php echo htmlspecialchars($specialiste['nomspecialiste']); ?>
            </a>
            </li>
             
        <?php endforeach; ?>
    
        <li class="dropdown">
        <a href="javascript:void(0);" onclick="toggleDropdown(event)">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
        </a>
        
    </li>
    <?php endif; ?>

   
</ul>

        <div class="main">
            <span class="menu-toggle" id="menuToggle">☰</span>
            <a href="" class="user">  </a>
           
            <?php
            

if (!isset($_SESSION['email'])) {
    echo '<a href="login.php"><i class="fa-solid fa-user-nurse"></i> espace médecin</a>';
}

if (isset($_SESSION['nom'])) {
    echo "" . htmlspecialchars($_SESSION['nom']) . "!";
} 
?>
      </div>