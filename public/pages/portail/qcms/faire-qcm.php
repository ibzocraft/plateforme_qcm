<?php
    require_once __DIR__ . '/../../../../includes/layout/page.php';
    require_once __DIR__ . '/../../../../includes/database/crud/qcm.php';
    require_once __DIR__ . '/../../../../includes/database/crud/question.php';
    require_once __DIR__ . '/../../../../includes/database/crud/reponse.php';
    require_once __DIR__ . '/../../../../includes/elements/module-header.php';
    

    if (!is_authenticated()) redirect("/pages/auth/connection.php");
    
    if (!isset($_GET['id'])) {
        redirect("/pages/portail/qcms/qcms.php");
    }

    $qcm_id = $_GET['id'];
    $qcm = recupererQcmParId($qcm_id);
    $questions = recupererQuestionsParQcm($qcm_id);

    if (!$qcm) {
        redirect("/pages/portail/qcms/qcms.php");
    }
?>

<!-- DEBUT PAGE -->
<?php begin_page("Faire le QCM : " . htmlspecialchars($qcm['titre'])) ?>
<?php include_once __DIR__ . '/../../../../includes/layout/header_student.php'; ?>
<!-- /DEBUT PAGE -->

<!-- CONTENU DE LA PAGE -->
 <div class="container-fluid p-4">
     <!-- HEADER -->
     <?php module_header(
         htmlspecialchars($qcm['titre']),
         htmlspecialchars($qcm['description'])
     ); ?>
     <!-- /HEADER -->
 
    <div class="bg-theme rounded-4 p-3 py-4 overflow-hidden mb-3">
        <form action="/resultat/submit" method="post" class="needs-validation spawn-ladder-up" novalidate>
            <input type="hidden" name="qcm_id" value="<?php echo $qcm_id; ?>">
    
            <?php if ($questions): ?>
                <?php foreach ($questions as $index => $question): ?>
                    <div class="card bg-theme-accent shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Question <?php echo $index + 1; ?>: <?php echo htmlspecialchars($question['texte_question']); ?></h5>
                            
                            <?php $reponses = recupererReponsesParQuestion($question['id']); ?>
                            <?php if ($reponses): ?>
                                <?php foreach ($reponses as $reponse): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reponses[<?php echo $question['id']; ?>]" id="reponse-<?php echo $reponse['id']; ?>" value="<?php echo $reponse['id']; ?>" required>
                                        <label class="form-check-label" for="reponse-<?php echo $reponse['id']; ?>">
                                            <?php echo htmlspecialchars($reponse['texte_reponse']); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">Aucune réponse disponible pour cette question.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary btn-lg w-100">Soumettre mes réponses</button>
            <?php else: ?>
                <p class="text-center">Ce QCM ne contient aucune question pour le moment.</p>
            <?php endif; ?>
        </form>
    </div>

 </div>
<!-- /CONTENU DE LA PAGE -->


<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../../includes/layout/footer.php'; ?>
<?php end_page() ?>
<!-- /FIN PAGE --> 