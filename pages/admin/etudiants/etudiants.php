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
<div class="container mt-5" style="min-height: 90vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-end gap-3">
            <h1 class="text-dark">Étudiants</h1>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb fs-6">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Etudiants</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEtudiantModal">Ajouter un étudiant</button>
    </div>


    <div class="d-flex justify-content-between mb-3">
    <div class="input-group flex-nowrap">
        <span class="input-group-text bg-theme border-end-0"><i class="bi bi-search text-dark"></i></span>
        <input type="text" id="searchEtudiant" class="form-control bg-theme border-start-0" placeholder="Rechercher des étudiants par numéro, nom, email ou classe..." aria-label="Username" aria-describedby="addon-wrapping">
    </div>
    </div>

    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">Numéro</th>
                <th scope="col">Nom Complet</th>
                <th scope="col">Email</th>
                <th scope="col">Classe</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($etudiants) > 0): ?>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td  name="numero_etudiant"><?= htmlspecialchars($etudiant['numero_etudiant']) ?></td>
                        <td name="nom_complet"><?= htmlspecialchars($etudiant['prenom']) . ' ' . htmlspecialchars($etudiant['nom']) ?></td>
                        <td class="text-muted" name="email"><?= htmlspecialchars($etudiant['email']) ?></td>
                        <td name="classe"><?= htmlspecialchars($etudiant['classe']) ?></td>
                        <td class="">
                            <a href="#" class="btn btn-primary btn-sm rounded btn-icon"><i class="bi bi-eye"></i></a>
                            <a href="#" class="btn btn-warning btn-sm rounded btn-icon"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded btn-icon"><i class="bi bi-trash"></i></a>
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

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Suivant</a>
            </li>
        </ul>
    </nav>
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
</script>
<!-- /JAVASCRIPT -->



<!-- /CONTENU DE LA PAGE -->


<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../includes/layout/footer.php'; ?>
<?php end_page() ?>
<!-- /FIN PAGE -->
