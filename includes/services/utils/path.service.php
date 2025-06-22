<?php require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../services/core/auth.service.php';

/**
 * Retourne le chemin complet de l'URL depuis l'url de base.
 * @param string $path Le chemin à ajouter à l'URL de base
 * @return string Le chemin complet de l'URL
 */
function get_full_url($path) {
    return $_ENV['BASE_URL'] . $path;
}

/**
 * Affiche le chemin complet de l'URL depuis l'url de base.
 * @param string $path Le chemin à ajouter à l'URL de base
 */
function echo_full_url($path) {
    echo get_full_url($path);
}

/**
 * Retourne le chemin de la page courante sans BASE_URL/pages/.
 * @return string Le chemin de la page courante
 */
function get_current_page(): string|null {
    $url = $_SERVER['REQUEST_URI'];
    if (!str_contains($url, 'pages/')) return null;

    $url = array_slice(explode('/', $url), 3);
    return implode('/', $url);
}

function echo_breadcrumb_from_url() {
    // TODO: Peaufiner et Finir cette fonction
    $url = $_SERVER['REQUEST_URI'];
    $url = array_slice(explode('/', $url), 4);
    $breadcrumb = '<ol class="breadcrumb fs-6">';
    foreach ($url as $key => $value) {
        $breadcrumb .= '<li class="breadcrumb-item"><a href="' . get_full_url($value) . '">' . $value . '</a></li>';
    }
    $breadcrumb .= '</ol>';
    echo $breadcrumb;
}

/**
 * Redirige vers la page précédente si possible, sinon vers la page spécifiée ou vers la page par défaut de l'utilisateur.
 * @param ?string $fallback_page Le chemin de la page à rediriger vers si aucune page précédente n'est trouvée (sans BASE_URL/pages/).
 * @return string
 */
function get_previous_page(?string $fallback_page = null) {
    $url = get_current_page();
    if (!$fallback_page) {
        $user = get_authenticated_user();
        if ($user) {
            if ($user['role'] == 'admin') $fallback_page = '/pages/admin/dashboard.php';
            if ($user['role'] == 'etudiant') $fallback_page = '/pages/portail/dashboard.php';
        } else {
            $fallback_page = '/pages/accueil.php';
        }
    }

    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    if (str_contains($referer, $url)) $referer = null;
    if ($referer && str_contains($referer, $_ENV['BASE_URL']) && str_contains($referer, "pages")) return $referer;
    return $fallback_page;
}