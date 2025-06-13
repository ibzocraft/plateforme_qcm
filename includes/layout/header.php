<?php include_once __DIR__ . '/../../includes/services/utils/path.php'; ?>
<header class="d-flex align-items-center justify-content-between border-bottom px-4 py-2">
<div class="d-flex align-items-center gap-2">
<div style="width: 1.5rem; height: 1.5rem;">
    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path></svg>
</div>
<h2 class="h5 fw-bold mb-0">Questions</h2>
</div>
<div class="d-flex flex-grow-1 justify-content-end gap-4">
<div class="d-flex align-items-center gap-4">
    <a class="text-dark small fw-medium text-decoration-none" href="<?php echo get_full_url('pages/accueil.php'); ?>">Accueil</a>
    <a class="text-dark small fw-medium text-decoration-none" href="<?php echo get_full_url('pages/a-propos.php'); ?>">A Propos</a>
    <div>
        <a class="btn btn-sm btn-primary fw-medium text-decoration-none" href="<?php echo get_full_url('pages/auth/inscription.php'); ?>">S'inscrire</a>
        <a class="text-dark btn btn-sm btn-outline-secondary fw-medium text-decoration-none" href="<?php echo get_full_url('pages/auth/connection.php'); ?>">Se Connecter</a>
    </div>
</div>
<a class="btn btn-icon <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'btn-dark' : 'btn-light'; ?>" role="button" href="<?php echo get_full_url("includes/api/theme.php?toggle"); ?>" >
    <i class="bi <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'bi-moon-stars' : 'bi-brightness-high'; ?>"></i>
</a>
</div>
</header>