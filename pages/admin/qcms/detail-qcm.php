<?php
    require_once __DIR__ . '/../../../includes/layout/page.php';
    require_once __DIR__ . '/../../../includes/database/db.php';
    require_once __DIR__ . '/../../../includes/database/crud/qcm.php';
    require_once __DIR__ . '/../../../includes/database/crud/question.php';
    require_once __DIR__ . '/../../../includes/database/crud/reponse.php';
    require_once __DIR__ . '/../../../includes/elements/module-header.php';

    if (!is_authenticated()) redirect(get_full_url("pages/auth/connection.php"));
    if (!is_admin()) redirect(get_full_url("pages/portail/dashboard.php"));

    if (!isset($_GET['id'])) {
        redirect(get_full_url("pages/admin/qcms/qcms.php"));
    }

    $qcm_id = $_GET['id'];
    $qcm = recupererQcmParId($qcm_id);
    $questions = recupererQuestionsParQcm($qcm_id);

    if (!$qcm) {
        redirect(get_full_url("pages/admin/qcms/qcms.php"));
    }
?>

<!-- DEBUT PAGE -->
<?php begin_page("Détail QCM") ?>
<?php include_once __DIR__ . '/../../../includes/layout/header_admin.php'; ?>
<!-- /DEBUT PAGE -->


<!-- CONTENU DE LA PAGE -->
<div class="container-fluid p-4 mb-5">
    <!-- HEADER -->
    <?php module_header(
        $qcm['titre'],
        $qcm['description']
    ); ?>
    <!-- /HEADER -->

    <div class="bg-theme rounded-4 p-3 py-4 overflow-hidden">
        <div class="row g-4 p-4">
            <!-- Colonne des Questions -->
            <div class="col-lg-7">
                <div class="bg-theme-accent p-4 rounded-4 h-100">
                    <h3 class="fs-4 fw-bold mb-4">Questions</h3>
                    <div class="accordion" id="questionsAccordion">
                        <?php if ($questions): ?>
                            <?php foreach ($questions as $index => $question): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $question['id']; ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $question['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $question['id']; ?>">
                                            <?php echo htmlspecialchars($question['texte_question']); ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $question['id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $question['id']; ?>" data-bs-parent="#questionsAccordion">
                                        <div class="accordion-body">
                                            <div class="d-flex justify-content-end mb-3">
                                                <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editQuestionModal" data-question-id="<?php echo $question['id']; ?>" data-question-texte="<?php echo htmlspecialchars($question['texte_question']); ?>">
                                                    <i class="bi bi-pencil-square"></i> Modifier
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteQuestionModal" data-question-id="<?php echo $question['id']; ?>" data-question-texte="<?php echo htmlspecialchars($question['texte_question']); ?>">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            </div>
                                            <h6 class="text-muted">Réponses</h6>
                                            <?php $reponses = recupererReponsesParQuestion($question['id']); ?>
                                            <ul class="list-group">
                                                <?php if ($reponses): ?>
                                                    <?php foreach ($reponses as $reponse): ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center <?php echo $reponse['est_correcte'] ? 'list-group-item-success' : ''; ?>">
                                                            <span>
                                                                <?php echo htmlspecialchars($reponse['texte_reponse']); ?>
                                                                <?php if ($reponse['est_correcte']): ?>
                                                                    <span class="badge bg-success rounded-pill ms-2">Correcte</span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <div>
                                                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editReponseModal" data-reponse-id="<?php echo $reponse['id']; ?>" data-reponse-texte="<?php echo htmlspecialchars($reponse['texte_reponse']); ?>" data-reponse-correcte="<?php echo $reponse['est_correcte']; ?>">
                                                                    <i class="bi bi-pencil"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteReponseModal" data-reponse-id="<?php echo $reponse['id']; ?>">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <li class="list-group-item text-center text-muted">Aucune réponse pour cette question.</li>
                                                <?php endif; ?>
                                            </ul>
                                            <div class="mt-3">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addReponseModal" data-question-id="<?php echo $question['id']; ?>">
                                                    <i class="bi bi-plus-circle"></i> Ajouter une réponse
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted p-4">
                                <p>Aucune question dans ce QCM pour le moment.</p>
                                <p>Commencez par en ajouter une en utilisant le formulaire ci-contre.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    
            <!-- Colonne d'Actions -->
            <div class="col-lg-5">
                <div class="bg-theme-accent p-4 rounded-4 h-100">
                    <h3 class="fs-4 fw-bold mb-4">Ajouter une Question</h3>
                    <form action="<?php echo get_full_url('includes/api/question.php?add&qcm_id=' . $qcm_id); ?>" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="qcm_id" value="<?php echo $qcm_id; ?>">
                        <div class="mb-3">
                            <label for="texte_question" class="form-label">Texte de la question <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="texte_question" name="texte_question" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Veuillez fournir le texte de la question.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ajouter la question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /CONTENU DE LA PAGE -->

<!-- MODAL AJOUT REPONSE -->
<div class="modal fade" id="addReponseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addReponseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo get_full_url('includes/api/reponse.php?add&qcm_id=' . $qcm_id); ?>" method="post" class="needs-validation" novalidate>
            <input type="hidden" name="question_id" id="questionIdInput">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Ajouter une réponse</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="texte_reponse" class="form-label">Texte de la réponse <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="texte_reponse" name="texte_reponse" rows="3" required></textarea>
                    <div class="invalid-feedback">
                        Veuillez fournir le texte de la réponse.
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="est_correcte" value="1" id="est_correcte">
                    <label class="form-check-label" for="est_correcte">
                        Cette réponse est-elle la bonne ?
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Ajouter la réponse</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- /MODAL AJOUT REPONSE -->

<!-- MODAL MODIFICATION QUESTION -->
<div class="modal fade" id="editQuestionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo get_full_url('includes/api/question.php?edit&qcm_id=' . $qcm_id); ?>" method="post" class="needs-validation" novalidate>
            <input type="hidden" name="question_id" id="editQuestionIdInput">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modifier la question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="edit_texte_question" class="form-label">Texte de la question <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="edit_texte_question" name="texte_question" rows="3" required></textarea>
                    <div class="invalid-feedback">
                        Veuillez fournir le texte de la question.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- /MODAL MODIFICATION QUESTION -->

<!-- MODAL SUPPRESSION QUESTION -->
<div class="modal fade" id="deleteQuestionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo get_full_url('includes/api/question.php?delete&qcm_id=' . $qcm_id); ?>" method="post">
                <input type="hidden" name="question_id" id="deleteQuestionIdInput">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Supprimer la question</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Voulez-vous vraiment supprimer la question : "<strong id="questionTexteToDelete"></strong>" ?</p>
                    <p class="text-danger">Cette action est irréversible et supprimera également toutes les réponses associées.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /MODAL SUPPRESSION QUESTION -->

<!-- MODAL MODIFICATION REPONSE -->
<div class="modal fade" id="editReponseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo get_full_url('includes/api/reponse.php?edit&qcm_id=' . $qcm_id); ?>" method="post" class="needs-validation" novalidate>
            <input type="hidden" name="reponse_id" id="editReponseIdInput">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modifier la réponse</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="edit_texte_reponse" class="form-label">Texte de la réponse <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="edit_texte_reponse" name="texte_reponse" rows="3" required></textarea>
                    <div class="invalid-feedback">
                        Veuillez fournir le texte de la réponse.
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="est_correcte" value="1" id="edit_est_correcte">
                    <label class="form-check-label" for="edit_est_correcte">
                        Cette réponse est-elle la bonne ?
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- /MODAL MODIFICATION REPONSE -->

<!-- MODAL SUPPRESSION REPONSE -->
<div class="modal fade" id="deleteReponseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo get_full_url('includes/api/reponse.php?delete&qcm_id=' . $qcm_id); ?>" method="post">
                <input type="hidden" name="reponse_id" id="deleteReponseIdInput">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Supprimer la réponse</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Voulez-vous vraiment supprimer cette réponse ?</p>
                    <p class="text-danger">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /MODAL SUPPRESSION REPONSE -->



<script>
    const addReponseModal = document.getElementById('addReponseModal');
    addReponseModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const questionId = button.getAttribute('data-question-id');
        const modalQuestionIdInput = addReponseModal.querySelector('#questionIdInput');
        modalQuestionIdInput.value = questionId;
    });

    const editQuestionModal = document.getElementById('editQuestionModal');
    editQuestionModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const questionId = button.getAttribute('data-question-id');
        const questionTexte = button.getAttribute('data-question-texte');
        
        const modalQuestionIdInput = editQuestionModal.querySelector('#editQuestionIdInput');
        const modalQuestionTexteInput = editQuestionModal.querySelector('#edit_texte_question');

        modalQuestionIdInput.value = questionId;
        modalQuestionTexteInput.value = questionTexte;
    });
    
    const deleteQuestionModal = document.getElementById('deleteQuestionModal');
    deleteQuestionModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const questionId = button.getAttribute('data-question-id');
        const questionTexte = button.getAttribute('data-question-texte');

        const modalQuestionIdInput = deleteQuestionModal.querySelector('#deleteQuestionIdInput');
        const modalQuestionTexte = deleteQuestionModal.querySelector('#questionTexteToDelete');

        modalQuestionIdInput.value = questionId;
        modalQuestionTexte.textContent = questionTexte;
    });

    const editReponseModal = document.getElementById('editReponseModal');
    editReponseModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const reponseId = button.getAttribute('data-reponse-id');
        const reponseTexte = button.getAttribute('data-reponse-texte');
        const reponseCorrecte = button.getAttribute('data-reponse-correcte');

        const modalReponseIdInput = editReponseModal.querySelector('#editReponseIdInput');
        const modalReponseTexteInput = editReponseModal.querySelector('#edit_texte_reponse');
        const modalReponseCorrecteInput = editReponseModal.querySelector('#edit_est_correcte');

        modalReponseIdInput.value = reponseId;
        modalReponseTexteInput.value = reponseTexte;
        modalReponseCorrecteInput.checked = (reponseCorrecte == 1);
    });
    
    const deleteReponseModal = document.getElementById('deleteReponseModal');
    deleteReponseModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const reponseId = button.getAttribute('data-reponse-id');
        
        const modalReponseIdInput = deleteReponseModal.querySelector('#deleteReponseIdInput');
        modalReponseIdInput.value = reponseId;
    });
</script>

<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../includes/layout/footer.php'; ?>
<?php end_page(); ?>
<!-- /FIN PAGE --> 