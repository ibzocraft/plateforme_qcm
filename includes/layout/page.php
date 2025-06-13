<?php

require_once __DIR__ . '/../services/core/auth.php';
require_once __DIR__ . '/../services/utils/path.php';
require_once __DIR__ . '/../services/utils/notification.php';

/**
 * Cette fonction génère et affiche les balises HTML initiales d'une page web.
 * Elle permet d'éviter la répétition du boilerplate dans chaque page.
 *
 * @param string $page_title Le titre de la page à afficher dans l'onglet du navigateur.
 * @return void
 */
function begin_page($page_title): void {
    $theme = "light";
    if(isset($_COOKIE["theme"])) $theme = $_COOKIE["theme"];
    // $theme = "dark";
    
    $assets_path = get_full_url("assets");

    $html = <<<HTML
    <!DOCTYPE html>
    <html lang="en"  data-bs-theme="$theme">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
        <link
        rel="stylesheet"
        as="style"
        onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
        />
        
        <title>$page_title</title>

        <!-- BOOTSTRAP -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        <!-- /BOOTSTRAP -->

        <!-- BOOTSTRAP ICONS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- /BOOTSTRAP ICONS -->

        <!-- CUSTOM CSS -->
        <link rel="stylesheet" href="$assets_path/css/style.css">
        <!-- /CUSTOM CSS -->
    </head>
    <body style='font-family: Inter, "Noto Sans", sans-serif;'>
        <!-- TOASTS -->
        <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1000;"></div>
        <!-- /TOASTS -->

        <!-- <div class="container-fluid d-flex flex-column min-vh-100"> -->
    HTML;

    echo $html;
}

/**
 * Cette fonction génère et affiche les balises HTML de fin de page.
 * Elle doit être obligatoirement appelée à la fin de chaque page debutant par begin_page().
 *
 * @return void
 */
function end_page(): void {
    $assets_path = get_full_url("assets");

    if (isset($_GET['error'])) notify_error("Erreur", $_GET['error']);
    if (isset($_GET['success'])) notify_success("Succès", $_GET['success']);
    // Effacer les notifications de l'url
    echo "<script>
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('error');
            url.searchParams.delete('success');
            window.history.replaceState(null, '', url);
        }
    </script>";

    $html = <<<HTML
        <!-- </div> -->

        <!-- CUSTOM JS -->
        <script src="$assets_path/js/main.js" type="module"></script>
        <!-- /CUSTOM JS -->
         
        <!-- BOOTSTRAP VALIDATION SCRIPT -->
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
                });
            }, false);
            })();
        </script>
        <!-- /BOOTSTRAP VALIDATION SCRIPT -->
    </body>
    </html>
    HTML;

    echo $html;
}
