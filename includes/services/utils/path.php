<?php require_once __DIR__ . '/../../config/config.php';

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
