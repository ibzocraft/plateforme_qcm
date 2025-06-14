<?php
// Vide pour le moment
?>

<footer class="py-4 border-top">
    <div class="container" style="max-width: 70vw; padding-top: 1rem;">
        <ul class="nav justify-content-center mb-3 justify-content-around">
            <li class="nav-item"><a href="<?php echo get_full_url('pages/auth/connection.php'); ?>" class="nav-link px-2 text-body-secondary">Connexion</a></li>
            <li class="nav-item"><a href="<?php echo get_full_url('pages/auth/inscription.php'); ?>" class="nav-link px-2 text-body-secondary">Inscription</a></li>
        </ul>

        <p class="text-center text-body-secondary">&copy; <?php echo date('Y'); ?> Plateforme QCM. Tous droits réservés.</p>
    </div>
</footer>
