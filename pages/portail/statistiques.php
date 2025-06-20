<?php
    require_once __DIR__ . '/../../includes/layout/page.php';
    require_once __DIR__ . '/../../includes/database/crud/resultat.php';
    require_once __DIR__ . '/../../includes/elements/module-header.php';

    if (!is_authenticated()) redirect(get_full_url("pages/auth/connection.php"));
    $student = get_authenticated_user();

    $student_results = recupererResultatsParUtilisateur($student['id']);

    $chart_labels = [];
    $chart_data = [];
    if ($student_results) {
        // Reverse to show oldest first on the chart
        $results_for_chart = array_reverse($student_results);
        foreach ($results_for_chart as $result) {
            $chart_labels[] = date('d/m/Y', strtotime($result['date_passe']));
            $chart_data[] = $result['score'];
        }
    }
?>

<!-- DEBUT PAGE -->
<?php begin_page("Statistiques") ?>
<?php include_once __DIR__ . '/../../includes/layout/header_student.php'; ?>
<!-- /DEBUT PAGE -->

<!-- CONTENU DE LA PAGE -->
<div class="container-fluid p-4 mb-5">
    <!-- Page Header -->
    <?php 
        module_header(
            "Vos Statistiques", 
            "Suivez votre progression et vos performances au fil du temps."
        ); 
    ?>
    <!-- /Page Header -->

    <div class="bg-theme rounded-4 p-3 overflow-hidden">
        <div class="row g-4 spawn-ladder-up">
            <!-- Chart -->
            <div class="col-lg-7">
                <div class="card bg-theme-accent h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Évolution des scores</h5>
                        <canvas id="scoresChart"></canvas>
                    </div>
                </div>
            </div>
    
            <!-- Full History Table -->
            <div class="col-lg-5">
                <div class="card bg-theme-accent h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Historique des QCMs</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">QCM</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($student_results): ?>
                                        <?php foreach ($student_results as $result): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($result['titre']); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($result['date_passe'])); ?></td>
                                                <td><?php echo number_format($result['score'], 2); ?>/20</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">Aucun QCM complété pour le moment.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /CONTENU DE LA PAGE -->

<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../includes/layout/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const scoresCtx = document.getElementById('scoresChart').getContext('2d');
        new Chart(scoresCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    label: 'Score',
                    data: <?php echo json_encode($chart_data); ?>,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20
                    }
                }
            }
        });
    });
</script>
<?php end_page() ?>
<!-- /FIN PAGE --> 