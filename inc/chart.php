<?php


$role = $_SESSION['role'] ?? "administrateur";

if ($role == "docteur") {
    echo ''; 
} else if ($role == "patient") {
    echo ''; 
} else if ($role == "administrateur") {
    echo '<div class="content-data">
            <div class="head">
                <h3>Report</h3>
                <div class="menu">
                    <i class="bx bx-dots-horizontal-rounded icon"></i>
                    <ul class="menu-link">
                        <li><a href="">Modifier</a></li>
                        <li><a href="">Enregistrer</a></li>
                        <li><a href="">Renommer</a></li>
                    </ul>
                </div>
            </div> 
            <div class="chart">
                <div id="chart"></div>
            </div> 
        </div>';
}
?>
