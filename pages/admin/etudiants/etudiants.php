<?php
require_once __DIR__ . '/../../../includes/layout/page.php';
require_once __DIR__ . '/../../../includes/services/utils/records.php';
require_once __DIR__ . '/../../../includes/services/etudiant/etudiant.service.php';

// if (!is_authenticated()) redirect("./auth/connection.php");

$etudiants = get_etudiants();
?>

<!-- DEBUT PAGE -->
<?php begin_page("Gestion des étudiants") ?>
<?php include_once __DIR__ . '/../../../includes/layout/header_admin.php'; ?>
<!-- /DEBUT PAGE -->



<!-- CONTENU DE LA PAGE -->

<div class="container-lg py-5">
    <div class="d-flex flex-column">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-4">
            <h2 class="text-dark fw-bold lh-tight m-0">Étudiants</h2>
            <button class="btn border" data-bs-toggle="modal" data-bs-target="#addEtudiantModal">
                <span class="truncate">Ajouter un étudiant</span>
            </button>
        </div>
        <div class="px-4 py-3">
            <div class="input-group flex-nowrap">
                <span class="input-group-text bg-theme border-end-0"><i class="bi bi-search text-dark"></i></span>
                <input type="text" id="searchEtudiant" class="form-control bg-theme border-start-0" placeholder="Rechercher des étudiants par numéro, nom, email ou classe..." aria-label="Username" aria-describedby="addon-wrapping">
            </div>
        </div>
        <div class="px-4 py-3">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-dark fw-semibold" style="width: 10%;">Numéro</th>
                            <th class="text-dark fw-semibold" style="width: 30%;">Nom Complet</th>
                            <th class="text-dark fw-semibold" style="width: 30%;">Email</th>
                            <th class="text-dark fw-semibold" style="width: 20%;">Classe</th>
                            <th class="text-secondary fw-semibold" style="width: 10%;">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($etudiants) > 0): ?>
                            <?php foreach ($etudiants as $etudiant): ?>
                                <tr>
                                    <td class="fw-semibold" name="numero_etudiant"><?= htmlspecialchars($etudiant['numero_etudiant']) ?></td>
                                    <td name="nom_complet"><?= htmlspecialchars($etudiant['prenom']) . ' ' . htmlspecialchars($etudiant['nom']) ?></td>
                                    <td class="text-secondary" name="email"><?= htmlspecialchars($etudiant['email']) ?></td>
                                    <td name="classe"><?= htmlspecialchars($etudiant['classe']) ?></td>
                                    <td class="">
                                        <a href="<?= echo_full_url("pages/admin/etudiants/detail-etudiant.php?id=" . $etudiant['id']) ?>" class="btn btn-primary btn-sm rounded btn-icon"><i class="bi bi-eye"></i></a>
                                        <a href="<?= echo_full_url("pages/admin/etudiants/edit-etudiant.php?id=" . $etudiant['id']) ?>" class="btn btn-warning btn-sm rounded btn-icon"><i class="bi bi-pencil-square"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm rounded btn-icon" data-bs-toggle="modal" data-bs-target="#deleteEtudiantModal" data-id="<?= $etudiant['id'] ?>"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Aucun étudiant trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINATION -->
        <div class="d-flex align-items-center justify-content-center p-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item">
                        <a href="#" class="page-link">
                            <div data-icon="CaretLeft" data-size="18px" data-weight="regular">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="currentColor" viewBox="0 0 256 256">
                                    <path d="M165.66,202.34a8,8,0,0,1-11.32,11.32l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L91.31,128Z"></path>
                                </svg>
                            </div>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                    <li class="page-item">
                        <a href="#" class="page-link">
                            <div data-icon="CaretRight" data-size="18px" data-weight="regular">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="currentColor" viewBox="0 0 256 256">
                                    <path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path>
                                </svg>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- /PAGINATION -->

    </div>
</div>

<!-- MODAL AJOUT ETUDIANT -->
<div class="modal fade" id="addEtudiantModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <form action="<?= echo_full_url("includes/api/etudiant.php?add") ?>" method="post" class="needs-validation" novalidate>    
            <div class="modal-header">
                <h1 class="modal-title fs-5">Ajouter un étudiant</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="numeroEtudiant">Numéro d'étudiant</label>
                            <input type="text" class="form-control" id="numeroEtudiant" name="numeroEtudiant">
                            <small class="text-muted">Numéro unique de l'étudiant. Exemple: ETU001</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="prenom">Prénoms <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                            <small class="text-muted">Prénoms de l'étudiant</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="nom">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                            <small class="text-muted">Nom de l'étudiant</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <small class="text-muted">Email de l'étudiant (utilisé pour la connexion)</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="classe">Classe <span class="text-danger">*</span></label>
                            <select class="form-select" id="classe" name="classe" required>
                                <option selected value="">Sélectionner une classe</option>
                                <?php foreach (get_all_classes() as $classe): ?>
                                    <option value="<?= $classe ?>"><?= $classe ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Classe de l'étudiant</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="motdepasse">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="motdepasse" name="motdepasse" minlength="5" required>
                            <small class="text-muted">Mot de passe de l'étudiant (utilisé pour la connexion)</small>
                        </div>
                    </div>
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
<!-- /MODAL AJOUT ETUDIANT -->

<!-- MODAL SUPPRESSION ETUDIANT -->
<div class="modal fade" id="deleteEtudiantModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
        <form action="<?= echo_full_url("includes/api/etudiant.php?delete") ?>" method="post">
            <input type="hidden" name="id" id="deleteEtudiantIdInput">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Supprimer un étudiant</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer l'étudiant <strong id="etudiantNameToDelete"></strong>&nbsp;?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- /MODAL SUPPRESSION ETUDIANT -->


<!-- JAVASCRIPT -->
<script>
    document.getElementById('searchEtudiant').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const numeroEtudiant = row.querySelector('td[name="numero_etudiant"]').textContent.toLowerCase();
            const nomComplet = row.querySelector('td[name="nom_complet"]').textContent.toLowerCase();
            const email = row.querySelector('td[name="email"]').textContent.toLowerCase();
            const classe = row.querySelector('td[name="classe"]').textContent.toLowerCase();
            if (numeroEtudiant.includes(searchValue) || nomComplet.includes(searchValue) || email.includes(searchValue) || classe.includes(searchValue)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });

    const deleteEtudiantModal = document.getElementById('deleteEtudiantModal')
    deleteEtudiantModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const etudiantId = button.getAttribute('data-id')
        
        const nomComplet = button.closest('tr').querySelector('td[name="nom_complet"]').textContent;

        const modalName = deleteEtudiantModal.querySelector('#etudiantNameToDelete')
        const modalInput = deleteEtudiantModal.querySelector('#deleteEtudiantIdInput')

        modalName.textContent = nomComplet
        modalInput.value = etudiantId
    })
</script>
<!-- /JAVASCRIPT -->

<!-- /CONTENU DE LA PAGE -->


<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../includes/layout/footer_admin.php'; ?>
<?php end_page() ?>
<!-- /FIN PAGE -->