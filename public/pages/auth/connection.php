<?php
    require_once __DIR__ . '/../../../includes/layout/page.php';
    require_once __DIR__ . '/../../../includes/services/core/functions.service.php';
    require_once __DIR__ . '/../../../includes/services/utils/notification.service.php';
?>

<!-- DEBUT PAGE -->
<?php begin_page("Accueil") ?>
<!-- /DEBUT PAGE -->

<?php include_once __DIR__ . '/../../../includes/layout/header.php'; ?>


<div class="container-fluid" style="padding-top: 6rem; padding-bottom: 5rem; min-height: 65vh;">

  <div class="row justify-content-center align-items-center">
    <div class="col-4">
      <h2 class="text-dark text-center pb-3 fs-2">Bienvenue.</h2>
      <hr class="border-secondary">

      <form action="/auth/login" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
          <label class="form-label fw-medium" for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control" required/>
          <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
        </div>
        <div class="mb-3 form-group">
          <label class="form-label fw-medium" for="password">Password</label>
          <input type="password"  id="password" name="password" placeholder="Enter your password" class="form-control" minlength="5" required/>
          <div class="invalid-feedback">Veuillez entrer un mot de passe valide (minimum 5 caractères).</div>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="rememberMe">
          <label class="form-check-label" name="rememberMe" for="rememberMe">Se souvenir de moi</label>
        </div>
        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-primary fw-bold">Se Connecter</button>
        </div>
      </form>

      <p class="text-secondary text-center pt-1 pb-3">Vous n'avez pas de compte? <a href="./inscription.php">Créer un compte</a></p>

    </div>
  </div>
</div>


<?php include_once __DIR__ . '/../../../includes/layout/footer.php'; ?>

<!-- FIN PAGE -->
<?php end_page() ?>
<!-- /FIN PAGE -->
