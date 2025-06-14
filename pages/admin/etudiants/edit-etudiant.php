<?php
require_once __DIR__ . '/../../../includes/layout/page.php';
require_once __DIR__ . '/../../../includes/services/etudiant/etudiant.service.php';
require_once __DIR__ . '/../../../includes/services/utils/records.php';
require_once __DIR__ . '/../../../includes/services/utils/path.php';

// if (!is_authenticated()) redirect("./auth/connection.php");

if (!isset($_GET['id'])) redirect($_SERVER['HTTP_REFERER']);
$etudiant = get_etudiant_by_id($_GET['id']);
?>

<!-- DEBUT PAGE -->
<?php begin_page("Modifier un étudiant") ?>
<?php include_once __DIR__ . '/../../../includes/layout/header_admin.php'; ?>
<!-- /DEBUT PAGE -->



<!-- CONTENU DE LA PAGE -->


<div class="container-fluid" style="padding-top: 6rem; padding-bottom: 5rem; min-height: 65vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-6">
                <h2 class="text-dark pb-3 fs-2">Modifier l'étudiant <?= $etudiant['id'] ?></h2>
                <hr class="border-secondary">

            <form action="<?= echo_full_url("includes/api/etudiant.php?edit") ?>" method="post" class="needs-validation" novalidate>
                <div class="row g-3">
                    <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="numeroEtudiant">Numéro d'étudiant</label>
                            <input type="text" class="form-control" id="numeroEtudiant" name="numeroEtudiant" value="<?= $etudiant['numero_etudiant'] ?>" disabled>
                            <small class="text-muted">Numéro unique de l'étudiant. Exemple: ETU001</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="prenom">Prénoms <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= $etudiant['prenom'] ?>" required>
                            <small class="text-muted">Prénoms de l'étudiant</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="nom">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= $etudiant['nom'] ?>" required>
                            <small class="text-muted">Nom de l'étudiant</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $etudiant['email'] ?>" required>
                            <small class="text-muted">Email de l'étudiant (utilisé pour la connexion)</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="classe">Classe <span class="text-danger">*</span></label>
                            <select class="form-select" id="classe" name="classe" required>
                                <option selected value="">Sélectionner une classe</option>
                                <?php foreach (get_all_classes() as $classe): ?>
                                    <option value="<?= $classe ?>" <?= $etudiant['classe'] == $classe ? 'selected' : '' ?>>
                                        <?= $classe ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Classe de l'étudiant</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-medium" for="motdepasse">Mot de passe</label>
                            <input type="password" class="form-control" id="motdepasse" name="motdepasse" minlength="5" autocomplete="off">
                            <small class="text-muted">Mot de passe de l'étudiant (utilisé pour la connexion)</small>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary fw-bold me-2">Modifier</button>
                        <a role="button" class="btn btn-danger fw-bold" href="<?= echo_full_url("pages/admin/etudiants/etudiants.php") ?>">Quitter</a>
                    </div>
                    
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /CONTENU DE LA PAGE -->



<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../includes/layout/footer_admin.php'; ?>
<?php end_page() ?>
<!-- /FIN PAGE -->