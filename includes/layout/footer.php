<?php
    require_once __DIR__ . '/../../includes/services/core/auth.php';

    $role = null;
    if (is_authenticated()) $role = get_authenticated_user()['role'];
?>

<footer class="py-4 border-top">
    <div class="container" style="max-width: 70vw; padding-top: 1rem;">
        <ul class="nav justify-content-center mb-3 justify-content-around">
            <?php if ($role == 'admin') { ?>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/admin/dashboard.php'); ?>" class="nav-link px-2 text-body-secondary">Dashboard</a></li>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/admin/qcms/qcms.php'); ?>" class="nav-link px-2 text-body-secondary">QCMs</a></li>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/admin/etudiants/etudiants.php'); ?>" class="nav-link px-2 text-body-secondary">Étudiants</a></li>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/admin/profil.php'); ?>" class="nav-link px-2 text-body-secondary">Profil</a></li>
            <?php } ?>
            <?php if ($role == 'etudiant') { ?>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/portail/dashboard.php'); ?>" class="nav-link px-2 text-body-secondary">Dashboard</a></li>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/portail/qcms/qcms.php'); ?>" class="nav-link px-2 text-body-secondary">QCMs</a></li>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/portail/statistiques.php'); ?>" class="nav-link px-2 text-body-secondary">Statistiques</a></li>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/portail/profil.php'); ?>" class="nav-link px-2 text-body-secondary">Profil</a></li>
            <?php } ?>
            <?php if ($role == null) { ?>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/auth/connection.php'); ?>" class="nav-link px-2 text-body-secondary">Connexion</a></li>
                <li class="nav-item"><a href="<?php echo get_full_url('pages/auth/inscription.php'); ?>" class="nav-link px-2 text-body-secondary">Inscription</a></li>
            <?php } ?>
        </ul>

        <p class="text-center text-body-secondary">&copy; <?php echo date('Y'); ?> Questions. Tous droits réservés.</p>
    </div>
</footer>
