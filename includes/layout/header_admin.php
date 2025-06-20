<?php 
require_once __DIR__ . '/../../includes/services/utils/path.php'; 
require_once __DIR__ . '/../../includes/services/core/functions.php';
$current_page = get_current_page();
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
    <a class="text-dark small fw-medium text-decoration-none <?php echo str_contains($current_page, "accueil.php") ? "active" : ""; ?>" href="<?php echo get_full_url("pages/accueil.php"); ?>">Accueil</a>
    <a class="text-dark small fw-medium text-decoration-none <?php echo str_contains($current_page, "dashboard.php") ? "active" : ""; ?>" href="<?php echo get_full_url("pages/admin/dashboard.php"); ?>">Dashboard</a>
    <a class="text-dark small fw-medium text-decoration-none <?php echo str_contains($current_page, "qcms/") ? "active" : ""; ?>" href="<?php echo get_full_url("pages/admin/qcms/qcms.php"); ?>">QCMs</a>
    <a class="text-dark small fw-medium text-decoration-none <?php echo str_contains($current_page, "etudiants/") ? "active" : ""; ?>" href="<?php echo get_full_url("pages/admin/etudiants/etudiants.php"); ?>">Etudiants</a>
</div>
<a class="btn btn-icon <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'btn-dark' : 'btn-light'; ?>" role="button" href="<?php echo get_full_url("includes/api/theme.php?toggle"); ?>" >
    <i class="bi <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'bi-moon-stars' : 'bi-brightness-high'; ?>"></i>
</a>
<div class="dropdown">
  <img
  role="button"
  class="rounded-circle object-fit-contain ms-3"
  src="<?php echo_full_url("/assets/images/profile-pic.png") ?>" alt="avatar" class="rounded-circle" style="width: 2.5rem; height: 2.5rem; background-size: cover; background-position: center;"
  data-bs-toggle="dropdown" aria-expanded="false"
  >
  <ul class="dropdown-menu pb-1">
    <li><a class="dropdown-item" href="<?php echo get_full_url("pages/admin/profil.php"); ?>">Mon Profil</a></li>
    <li><hr class="dropdown-divider mt-1 mb-1"></li>
    <li>
        <a class="dropdown-item text-danger small fw-bold" href="<?php echo get_full_url("includes/api/auth.php?logout"); ?>">
            <i class="bi bi-box-arrow-left me-2"></i>
            Se Déconnecter
        </a>
    </li>
  </ul>
</div>
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