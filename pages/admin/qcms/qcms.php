<?php
    require_once __DIR__ . '/../../../includes/layout/page.php';
    require_once __DIR__ . '/../../../includes/database/db.php';
    require_once __DIR__ . '/../../../includes/database/crud/qcm.php';

    if (!is_authenticated()) redirect(get_full_url("pages/auth/connection.php"));
    if (!is_admin()) redirect(get_full_url("pages/portail/dashboard.php"));

    $qcms = recupererQcms();
?>

<!-- DEBUT PAGE -->
<?php begin_page("QCMs") ?>
<?php include_once __DIR__ . '/../../../includes/layout/header_admin.php'; ?>
<!-- /DEBUT PAGE -->


<!-- CONTENU DE LA PAGE -->
<div class="container-lg py-5">
    <div class="d-flex flex-column">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-4">
            <h2 class="text-dark fw-bold lh-tight m-0">Gestion des QCMs</h2>
            <button class="btn border" data-bs-toggle="modal" data-bs-target="#addQcmModal">
                <span class="truncate">Ajouter un QCM</span>
            </button>
        </div>
        <div class="px-4 py-3">
            <div class="input-group flex-nowrap">
                <span class="input-group-text bg-theme border-end-0"><i class="bi bi-search text-dark"></i></span>
                <input type="text" id="searchQcm" class="form-control bg-theme border-start-0" placeholder="Rechercher des QCMs par titre ou description..." aria-label="Search QCM" aria-describedby="addon-wrapping">
            </div>
        </div>
        <div class="px-4 py-3">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" class="text-dark fw-semibold" style="width: 10%;">ID</th>
                            <th scope="col" class="text-dark fw-semibold" style="width: 30%;">Titre</th>
                            <th scope="col" class="text-dark fw-semibold" style="width: 40%;">Description</th>
                            <th scope="col" class="text-secondary fw-semibold" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($qcms): ?>
                            <?php foreach ($qcms as $qcm): ?>
                                <tr>
                                    <th scope="row" class="fw-semibold" name="qcm_id"><?php echo $qcm['id']; ?></th>
                                    <td name="qcm_titre"><?php echo $qcm['titre']; ?></td>
                                    <td class="text-secondary" name="qcm_description"><?php echo $qcm['description']; ?></td>
                                    <td>
                                        <a href="<?php echo get_full_url('pages/admin/qcms/detail-qcm.php?id=' . $qcm['id']); ?>" class="btn btn-sm btn-primary btn-icon">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-warning btn-icon" data-bs-toggle="modal" data-bs-target="#editQcmModal" data-qcm-id="<?php echo $qcm['id']; ?>" data-qcm-titre="<?php echo htmlspecialchars($qcm['titre']); ?>" data-qcm-description="<?php echo htmlspecialchars($qcm['description']); ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#deleteQcmModal" data-qcm-id="<?php echo $qcm['id']; ?>" data-qcm-titre="<?php echo htmlspecialchars($qcm['titre']); ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Aucun QCM trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /CONTENU DE LA PAGE -->

<!-- MODAL AJOUT QCM -->
<div class="modal fade" id="addQcmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo get_full_url('includes/api/qcm.php?add'); ?>" method="post" class="needs-validation" novalidate>
            <div class="modal-header">
                <h1 class="modal-title fs-5">Ajouter un QCM</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                    <div class="invalid-feedback">
                        Veuillez fournir un titre pour le QCM.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- /MODAL AJOUT QCM -->

<!-- MODAL MODIFICATION QCM -->
<div class="modal fade" id="editQcmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo get_full_url('includes/api/qcm.php?edit'); ?>" method="post" class="needs-validation" novalidate>
            <input type="hidden" name="id" id="editQcmId">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modifier le QCM</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editTitre" class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="editTitre" name="titre" required>
                    <div class="invalid-feedback">
                        Veuillez fournir un titre pour le QCM.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="editDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
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
<!-- /MODAL MODIFICATION QCM -->

<!-- MODAL SUPPRESSION QCM -->
<div class="modal fade" id="deleteQcmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="<?php echo get_full_url('includes/api/qcm.php?delete'); ?>" method="post">
            <input type="hidden" name="id" id="deleteQcmId">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Supprimer le QCM</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer le QCM "<strong id="qcmNameToDelete"></strong>" ?</p>
                <p class="text-danger">Cette action est irréversible et supprimera également toutes les questions et réponses associées.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- /MODAL SUPPRESSION QCM -->



<script>
    // Live search for QCMs
    document.getElementById('searchQcm').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            // Ensure the row has the cells before trying to access them
            const titreCell = row.querySelector('td[name="qcm_titre"]');
            const descriptionCell = row.querySelector('td[name="qcm_description"]');
            
            if (titreCell && descriptionCell) {
                const titre = titreCell.textContent.toLowerCase();
                const description = descriptionCell.textContent.toLowerCase();
                
                if (titre.includes(searchValue) || description.includes(searchValue)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    const editQcmModal = document.getElementById('editQcmModal');
    editQcmModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        
        const qcmId = button.getAttribute('data-qcm-id');
        const qcmTitre = button.getAttribute('data-qcm-titre');
        const qcmDescription = button.getAttribute('data-qcm-description');
        
        const modalIdInput = editQcmModal.querySelector('#editQcmId');
        const modalTitreInput = editQcmModal.querySelector('#editTitre');
        const modalDescriptionInput = editQcmModal.querySelector('#editDescription');
        
        modalIdInput.value = qcmId;
        modalTitreInput.value = qcmTitre;
        modalDescriptionInput.value = qcmDescription;
    });
    
    const deleteQcmModal = document.getElementById('deleteQcmModal');
    deleteQcmModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        
        const qcmId = button.getAttribute('data-qcm-id');
        const qcmTitre = button.getAttribute('data-qcm-titre');
        
        const modalIdInput = deleteQcmModal.querySelector('#deleteQcmId');
        const modalTitre = deleteQcmModal.querySelector('#qcmNameToDelete');
        
        modalIdInput.value = qcmId;
        modalTitre.textContent = qcmTitre;
    });
</script>

<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../includes/layout/footer.php'; ?>
<?php end_page(); ?>

<!-- /FIN PAGE -->