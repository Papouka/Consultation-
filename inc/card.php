<?php


$role = $_SESSION['role'] ?? "administrateur";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hosto_bd', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer le nombre total de patients
    $stmt = $pdo->query("SELECT COUNT(*) as total_patients FROM patient");
    $totalPatients = $stmt->fetchColumn();

    // Récupérer le nombre total de consultations
    $stmt = $pdo->query("SELECT COUNT(*) as total_consultations FROM consultation");
    $totalConsultations = $stmt->fetchColumn();

    // Récupérer le nombre total de docteurs
    $stmt = $pdo->query("SELECT COUNT(*) as total_doctors FROM docteur");
    $totalDoctors = $stmt->fetchColumn();

    // Taux de satisfaction (exemple fictif)
    $tauxSatisfaction = 85; // Vous pouvez le calculer à partir de vos données

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Styles CSS
echo '
<style>
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: hsl(158, 97%, 39%);
        color: white;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    img {
        border-radius: 50%;
    }
    .dataTables_wrapper {
        margin-top: 20px;
    }
</style>';

if ($role == "docteur") {
    echo '
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalPatients) . '</h2>
                <p>Nombres de Patients</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="30%"></span>
        <span class="label">30%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalConsultations) . '</h2>
                <p>Nombre de consultations</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="90%"></span>
        <span class="label">90%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($tauxSatisfaction) . '%</h2>
                <p>Taux de Satisfaction</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="' . htmlspecialchars($tauxSatisfaction) . '%"></span>
        <span class="label">' . htmlspecialchars($tauxSatisfaction) . '%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalDoctors) . '</h2>
                <p>Nombre de Docteurs</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="40%"></span>
        <span class="label">40%</span>
    </div>';

    
} else if ($role == "patient") {
    echo '
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalPatients) . '</h2>
                <p>Nombres de Patients</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="30%"></span>
        <span class="label">30%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalConsultations) . '</h2>
                <p>Nombre de consultations</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="90%"></span>
        <span class="label">90%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($tauxSatisfaction) . '%</h2>
                <p>Taux de Satisfaction</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="' . htmlspecialchars($tauxSatisfaction) . '%"></span>
        <span class="label">' . htmlspecialchars($tauxSatisfaction) . '%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalDoctors) . '</h2>
                <p>Nombre de Docteurs</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="40%"></span>
        <span class="label">40%</span>
    </div>'; 
} else if ($role == "administrateur") {
    echo '
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalPatients) . '</h2>
                <p>Patients</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="30%"></span>
        <span class="label">30%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalDoctors) . '</h2>
                <p>Docteurs</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="90%"></span>
        <span class="label">90%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($tauxSatisfaction) . '%</h2>
                <p>Taux de Satisfaction</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="' . htmlspecialchars($tauxSatisfaction) . '%"></span>
        <span class="label">' . htmlspecialchars($tauxSatisfaction) . '%</span>
    </div>
    <div class="card">
        <div class="head">
            <div>
                <h2>' . htmlspecialchars($totalConsultations) . '</h2>
                <p>Consultations</p>
            </div>
            <i class="fas fa-chart-line icon"></i>
        </div>
        <span class="progress" data-value="40%"></span>
        <span class="label">40%</span>
    </div>';
}
?>
