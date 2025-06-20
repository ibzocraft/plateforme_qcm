<?php
    require_once __DIR__ . '/../../includes/layout/page.php';
    require_once __DIR__ . '/../../includes/database/db.php';
    require_once __DIR__ . '/../../includes/elements/module-header.php';

    if (!is_authenticated()) redirect(get_full_url("pages/auth/connection.php"));

    $student = get_authenticated_user();
?>

<!-- DEBUT PAGE -->
<?php begin_page("Mon Profil") ?>
<?php include_once __DIR__ . '/../../includes/layout/header_student.php'; ?>
<!-- /DEBUT PAGE -->


<!-- CONTENU DE LA PAGE -->
<div class="container-fluid p-4 mb-5">
    <!-- Page Header -->
    <?php 
        module_header(
            "Mon Profil", 
            "Gérez vos informations personnelles et vos paramètres."
        ); 
    ?>
    <!-- /Page Header -->

    <div class="bg-theme rounded-4 p-3 overflow-hidden">
        <div class="row spawn-ladder-up">
            <div class="col-md-6">
                <div class="bg-theme-accent p-4 rounded-4 mb-4">
                    <h3 class="fs-4 fw-bold mb-3">Informations personnelles</h3>
                    <form action="<?php echo get_full_url('includes/api/student_profil.php?update_info'); ?>" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($student['prenom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($student['nom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="classe" class="form-label">Classe</label>
                            <input type="text" class="form-control" id="classe" name="classe" value="<?php echo htmlspecialchars($student['classe']); ?>" readonly disabled>
                        </div>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-theme-accent p-4 rounded-4 mb-4">
                    <h3 class="fs-4 fw-bold mb-3">Changer le mot de passe</h3>
                    <form action="<?php echo get_full_url('includes/api/student_profil.php?update_password'); ?>" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="5">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="5">
                        </div>
                        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /CONTENU DE LA PAGE -->


<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../includes/layout/footer.php'; ?>
<?php end_page(); ?>
<!-- /FIN PAGE --> 