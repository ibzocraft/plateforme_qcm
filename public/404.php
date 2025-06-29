<?php
require_once __DIR__ . "/../includes/layout/page.php";

?>

<?php begin_page("Page Introuvable") ?>

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-1">404</h1>
            <p class="lead">La page que vous cherchez n'existe pas.</p>
            <a href="/" class="btn btn-dark">Retour à l'accueil</a>
        </div>
    </div>
</div>

<?php end_page() ?>