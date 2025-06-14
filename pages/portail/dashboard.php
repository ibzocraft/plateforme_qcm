<?php
    require_once __DIR__ . '/../../includes/layout/page.php';
    require_once __DIR__ . '/../../includes/database/crud/qcm.php';
    require_once __DIR__ . '/../../includes/database/crud/resultat.php';

    if (!is_authenticated()) redirect(get_full_url("pages/auth/connection.php"));
    $student = get_authenticated_user();

    $total_qcms = countQcms();
    $student_results = recupererResultatsParUtilisateur($student['id']);
    $completed_qcms_count = count($student_results);
    
    $average_score = 0;
    if ($completed_qcms_count > 0) {
        $total_score = 0;
        foreach ($student_results as $result) {
            $total_score += $result['score'];
        }
        $average_score = $total_score / $completed_qcms_count;
    }
?>

<!-- DEBUT PAGE -->
<?php begin_page("Dashboard") ?>
<?php include_once __DIR__ . '/../../includes/layout/header_student.php'; ?>
<!-- /DEBUT PAGE -->

<!-- CONTENU DE LA PAGE -->
<div class="container-fluid p-4 mb-5">
    <div class="row p-4 justify-content-between">
        <div class="col-8">
            <p class="text-custom-dark tracking-light fs-2 fw-bold leading-tight min-w-72">Bonjour, <?php echo htmlspecialchars($student['prenom']); ?> !</p>
            <p class="text-muted">Bienvenue sur votre portail étudiant. Voici un résumé de votre activité.</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">QCMs Disponibles</h6>
                    <h2 class="card-title"><?php echo $total_qcms; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">QCMs Terminés</h6>
                    <h2 class="card-title"><?php echo $completed_qcms_count; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Note Moyenne</h6>
                    <h2 class="card-title"><?php echo number_format($average_score, 2); ?>/20</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card bg-theme h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Activité Récente</h5>
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
                                    <?php foreach (array_slice($student_results, 0, 5) as $result): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($result['titre']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($result['date_passe'])); ?></td>
                                            <td><?php echo number_format($result['score'], 2); ?>/20</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Aucune activité récente.</td>
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
<!-- /CONTENU DE LA PAGE -->


<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../includes/layout/footer_student.php'; ?>
<?php end_page() ?>
<!-- /FIN PAGE -->
