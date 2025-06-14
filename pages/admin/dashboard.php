<?php
    require_once __DIR__ . '/../../includes/layout/page.php';
    require_once __DIR__ . '/../../includes/database/db.php';
    require_once __DIR__ . '/../../includes/database/crud/utilisateur.php';
    require_once __DIR__ . '/../../includes/database/crud/qcm.php';
    require_once __DIR__ . '/../../includes/database/crud/resultat.php';

    if (!is_authenticated()) redirect(get_full_url("pages/auth/connection.php"));
    if (!is_admin()) redirect(get_full_url("pages/portail/dashboard.php"));

    $admin = get_authenticated_user();

    // Data for Summary Cards with arrows
    function calculate_percentage_change($current, $previous) {
        if ($previous == 0) {
            return $current > 0 ? 100.0 : 0.0; // Avoid division by zero, show 100% if it grew from 0
        }
        return (($current - $previous) / $previous) * 100.0;
    }

    // Helper function for rendering arrows
    function render_change_indicator($change_percentage, $is_raw_value = false) {
        if ($change_percentage == 0) return ''; // No change, no indicator

        $color_class = $change_percentage > 0 ? 'text-success' : 'text-danger';
        $icon_class = $change_percentage > 0 ? 'bi-arrow-up' : 'bi-arrow-down';
        $suffix = $is_raw_value ? '' : '%';
        // For raw values, show a sign. For percentages, the arrow implies the direction.
        $sign = ($is_raw_value && $change_percentage > 0) ? '+' : '';
        $formatted_change = number_format($is_raw_value ? $change_percentage : abs($change_percentage), 1);

        return <<<HTML
        <small class="{$color_class} fs-6 align-bottom"><i class="bi {$icon_class}"></i> {$sign}{$formatted_change}{$suffix}</small>
        HTML;
    }

    // New Students (Last 30 days)
    $current_students = countNouveauxUtilisateursEntreJours('etudiant', 29, 0);
    $previous_students = countNouveauxUtilisateursEntreJours('etudiant', 59, 30);
    $student_change_percent = calculate_percentage_change($current_students, $previous_students);

    // QCMs Created (Last 30 days)
    $current_qcms_created = countQcmsCreesEntreJours(29, 0);
    $previous_qcms_created = countQcmsCreesEntreJours(59, 30);
    $qcm_change_percent = calculate_percentage_change($current_qcms_created, $previous_qcms_created);

    // Participations (Last 30 days)
    $current_participations = countParticipationsEntreJours(29, 0);
    $previous_participations = countParticipationsEntreJours(59, 30);
    $participation_change_percent = calculate_percentage_change($current_participations, $previous_participations);

    // Average Score (Last 30 days)
    $current_avg_score = getAverageScoreEntreJours(29, 0);
    $previous_avg_score = getAverageScoreEntreJours(59, 30);
    // For score, showing the raw change is more intuitive than percentage.
    $score_change_raw = $current_avg_score - $previous_avg_score;

    // Charts Data
    // 1. New Registrations Chart
    $new_users_data_from_db = getNouveauxInscritsParMois(6);
    $new_users_labels = [];
    $new_users_values = array_fill(0, 6, 0); // Array of 6 zeros

    $month_map = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = new DateTime("-$i months");
        $formatted_month_ym = $date->format('Y-m');
        // Use ucwords and a mapping for French months to ensure correct capitalization and language.
        $month_name = strtr($date->format('F'), [
            'January' => 'Janvier', 'February' => 'Février', 'March' => 'Mars', 'April' => 'Avril',
            'May' => 'Mai', 'June' => 'Juin', 'July' => 'Juillet', 'August' => 'Août',
            'September' => 'Septembre', 'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'
        ]);
        $new_users_labels[] = $month_name;
        $month_map[$formatted_month_ym] = 5 - $i; // Map 'YYYY-MM' to its index
    }

    foreach ($new_users_data_from_db as $data) {
        $db_month = $data['mois']; // This is in 'YYYY-MM' format
        if (isset($month_map[$db_month])) {
            $index = $month_map[$db_month];
            $new_users_values[$index] = (int)$data['count'];
        }
    }

    // 2. QCM Activity Chart
    $activity_data_from_db = getActiviteQcmParJour(7);
    $activity_labels = [];
    $activity_values = array_fill(0, 7, 0); // Array of 7 zeros

    $date_map = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = new DateTime("-$i days");
        $formatted_date = $date->format('Y-m-d');
        $activity_labels[] = $date->format('D, M j');
        $date_map[$formatted_date] = 6 - $i; // Map date to its index in the array
    }

    foreach ($activity_data_from_db as $data) {
        $db_date = $data['jour'];
        if (isset($date_map[$db_date])) {
            $index = $date_map[$db_date];
            $activity_values[$index] = (int)$data['count'];
        }
    }

    // 3. Audience Chart
    $audience_data = getRepartionEtudiantsParClasse();
    $audience_labels = [];
    $audience_values = [];
    foreach ($audience_data as $data) {
        $audience_labels[] = $data['classe'];
        $audience_values[] = $data['count'];
    }
    
    // Recent Results
    $recent_results = recupererDerniersResultats(5);
?>

<!-- DEBUT PAGE -->
<?php begin_page("Dashboard Administrateur") ?>
<?php include_once __DIR__ . '/../../includes/layout/header_admin.php'; ?>
<!-- /DEBUT PAGE -->


<!-- CONTENU DE LA PAGE -->
<div class="container-fluid p-4 mb-5">
    <div class="row p-4 justify-content-between">
        <div class="col-8">
            <p class="text-custom-dark tracking-light fs-2 fw-bold leading-tight min-w-72">Bonjour, <?php echo htmlspecialchars($admin['prenom']); ?> !</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Nouveaux Étudiants (30j)</h6>
                    <h2 class="card-title"><?php echo $current_students; ?> <?php echo render_change_indicator($student_change_percent); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">QCMs Créés (30j)</h6>
                    <h2 class="card-title"><?php echo $current_qcms_created; ?> <?php echo render_change_indicator($qcm_change_percent); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Participations (30j)</h6>
                    <h2 class="card-title"><?php echo $current_participations; ?> <?php echo render_change_indicator($participation_change_percent); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Score Moyen (30j)</h6>
                    <h2 class="card-title"><?php echo number_format($current_avg_score, 2); ?> <span class="fs-6">/ 20</span> <?php echo render_change_indicator($score_change_raw, true); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Activity Chart -->
        <div class="col-lg-5">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-3">Activité des QCM (7 derniers jours)</h5>
                    <div class="flex-grow-1" style="position: relative; min-height: 250px;">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Users Chart -->
        <div class="col-lg-7">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-3">Nouveaux Inscrits (6 derniers mois)</h5>
                    <div class="flex-grow-1" style="position: relative; min-height: 250px;">
                        <canvas id="newUsersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Audience Insight Chart -->
        <div class="col-lg-7">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">Répartition des Étudiants par Classe</h6>
                    <div class="flex-grow-1 d-flex justify-content-center align-items-center" style="position: relative; max-height: 300px;">
                        <canvas id="audienceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Results -->
        <div class="col-lg-5">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Résultats Récents</h6>
                    <ul class="list-unstyled">
                        <?php if ($recent_results): ?>
                            <?php foreach ($recent_results as $result): ?>
                                <li class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:30px; height:30px;"><i class="bi bi-check-lg"></i></div>
                                        <div>
                                            <p class="mb-0 small"><?php echo htmlspecialchars($result['prenom'] . ' ' . $result['nom']); ?> a complété <strong><?php echo htmlspecialchars($result['titre']); ?></strong></p>
                                            <p class="mb-0 text-muted small"><?php echo date('d M, H:i', strtotime($result['date_passe'])); ?></p>
                                        </div>
                                    </div>
                                    <span class="fw-bold"><?php echo number_format($result['score'], 2); ?>/20</span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="text-center text-muted">Aucun résultat récent.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /CONTENU DE LA PAGE -->

<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../includes/layout/footer_admin.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // New Users Chart
        const newUsersCtx = document.getElementById('newUsersChart').getContext('2d');
        new Chart(newUsersCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($new_users_labels); ?>,
                datasets: [{
                    label: 'Nouveaux Étudiants',
                    data: <?php echo json_encode($new_users_values); ?>,
                    backgroundColor: 'rgba(13, 110, 253, 0.5)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($activity_labels); ?>,
                datasets: [{
                    label: 'QCMs Pris',
                    data: <?php echo json_encode($activity_values); ?>,
                    borderColor: 'rgba(25, 135, 84, 1)',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
        
        // Audience Chart
        const audienceCtx = document.getElementById('audienceChart').getContext('2d');
        new Chart(audienceCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($audience_labels); ?>,
                datasets: [{
                    label: 'Étudiants',
                    data: <?php echo json_encode($audience_values); ?>,
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.7)',
                        'rgba(25, 135, 84, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(220, 53, 69, 0.7)',
                        'rgba(111, 66, 193, 0.7)',
                        'rgba(253, 126, 20, 0.7)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    });
</script>
<?php end_page() ?>
<!-- /FIN PAGE -->
