<?php 
    require_once __DIR__ . '/../services/utils/path.service.php'; 
    require_once __DIR__ . '/../services/core/auth.service.php';

    $current_page = get_current_page();
    $role = null;
    if (is_authenticated()) $role = get_authenticated_user()['role'];
?>
<header class="d-flex align-items-center justify-content-between border-bottom px-4 py-2 mx-3 mt-3 rounded-4 bg-theme position-sticky top-0" style="z-index: 500;">
<div class="d-flex align-items-center gap-2">
<div style="width: 1.5rem; height: 1.5rem;">
    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path></svg>
</div>
<h2 class="h5 fw-bold mb-0">Questions</h2>
</div>
<div class="d-flex flex-grow-1 justify-content-end gap-4">
<div class="d-flex align-items-center gap-4">
    <!-- Accueil -->
    <a class="text-dark small fw-medium text-decoration-none <?php echo str_contains($current_page, "accueil.php") ? "active" : ""; ?>" href="/pages/accueil.php">Accueil</a>
    <a class="text-dark small fw-medium text-decoration-none <?php echo str_contains($current_page, "a-propos.php") ? "active" : ""; ?>" href="/pages/a-propos.php">A Propos</a>
    <?php if ($role == null) { ?>
        <div>
            <a class="btn btn-sm btn-primary fw-medium text-decoration-none" href="/pages/auth/inscription.php">S'inscrire</a>
            <a class="text-dark btn btn-sm btn-outline-secondary fw-medium text-decoration-none" href="/pages/auth/connection.php">Se Connecter</a>
        </div>
    <?php } ?>
    <?php if ($role == 'admin') { ?>
        <a class="btn btn-sm btn-dark fw-medium text-decoration-none" href="/pages/admin/dashboard.php">Panel Admin</a>
    <?php } ?>
    <?php if ($role == 'etudiant') { ?>
        <a class="btn btn-sm btn-dark fw-medium text-decoration-none" href="/pages/portail/dashboard.php">Portail Etudiant</a>
    <?php } ?>
    <!-- /Accueil -->
</div>
<a class="btn btn-icon <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'btn-dark' : 'btn-light'; ?>" role="button" href="/settings/toggle-theme">
    <i class="bi <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'bi-moon-stars' : 'bi-brightness-high'; ?>"></i>
</a>
</div>
</header>

<style>
    header {
        transition: all 0.5s ease;
    }
</style>
<script>
window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    if (window.scrollY > 0) {
        header.classList.remove('mx-3', 'rounded-4');
    } else {
        header.classList.add('mx-3', 'rounded-4');
        
    }
});
</script>