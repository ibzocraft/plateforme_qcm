<?php
    require_once __DIR__ . '/../../../includes/layout/page.php';
    require_once __DIR__ . '/../../../includes/database/crud/qcm.php';
    require_once __DIR__ . '/../../../includes/database/crud/resultat.php';
    require_once __DIR__ . '/../../../includes/elements/module-header.php';

    if (!is_authenticated()) redirect(get_full_url("pages/auth/connection.php"));
    $student = get_authenticated_user();

    $qcms = recupererQcms();
    $student_results_raw = recupererResultatsParUtilisateur($student['id']);
    
    $student_results = [];
    foreach ($student_results_raw as $result) {
        $student_results[$result['qcm_id']] = $result;
    }
?>

<!-- DEBUT PAGE -->
<?php begin_page("Liste des QCMs") ?>
<?php include_once __DIR__ . '/../../../includes/layout/header_student.php'; ?>
<!-- /DEBUT PAGE -->

<!-- CONTENU DE LA PAGE -->
<div class="container-fluid p-4 mb-5">
    <!-- Page Header -->
    <?php 
        module_header(
            "Liste des QCMs", 
            "Voici la liste de tous les QCMs disponibles. Commencez un nouveau QCM ou revoyez vos résultats passés."
        ); 
    ?>
    <!-- /Page Header -->

    <div class="bg-theme rounded-4 p-3 overflow-hidden">
        <div class="row g-4 spawn-ladder-up">
            <?php if ($qcms): ?>
                <?php foreach ($qcms as $qcm): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card bg-theme-accent h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($qcm['titre']); ?></h5>
                                <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($qcm['description']); ?></p>
                                
                                <?php if (isset($student_results[$qcm['id']])): 
                                    $result = $student_results[$qcm['id']];
                                ?>
                                    <div class="mt-auto">
                                        <p class="mb-2"><strong>Votre score :</strong> <?php echo number_format($result['score'], 2); ?>/20</p>
                                        <button class="btn btn-secondary w-100" disabled>Fait</button>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-auto">
                                        <a href="<?php echo get_full_url('pages/portail/qcms/faire-qcm.php?id=' . $qcm['id']); ?>" class="btn btn-primary w-100">Commencer</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Aucun QCM disponible pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- /CONTENU DE LA PAGE -->


<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../includes/layout/footer.php'; ?>
<?php end_page() ?>
<!-- /FIN PAGE --> 