<?php
    require_once __DIR__ . '/../../includes/layout/page.php';
    require_once __DIR__ . '/../../includes/database/db.php';

    // if (!is_authenticated()) redirect("./auth/connection.php");
    // createTables();
    // seedDB();
?>

<!-- DEBUT PAGE -->
<?php begin_page("Accueil") ?>
<!-- /DEBUT PAGE -->

<?php include_once __DIR__ . '/../../includes/layout/header.php'; ?>


<div class="container-fluid" style="margin-top: 4rem;">
  <div class="row justify-content-center align-items-center">
    <div class="col-4">
      <h2 class="text-dark text-center fs-2">Créer un compte.</h2>
      <hr class="border-secondary">
      <form class="needs-validation" novalidate>
        <div class="mb-3">
          <label class="form-label fw-medium" for="nom">Nom</label>
          <input type="text" id="nom" placeholder="Entrer votre nom" class="form-control" />
          <div class="invalid-feedback">Veuillez entrer un nom.</div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-medium" for="prenom">Prénom</label>
          <input type="text" id="prenom" placeholder="Entrer votre prénom" class="form-control" />
          <div class="invalid-feedback">Veuillez entrer un prénom.</div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-medium" for="email">Email</label>
          <input type="email" id="email" placeholder="Enter your email" class="form-control" />
          <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
        </div>
        <div class="mb-3 form-group">
          <label class="form-label fw-medium" for="password">Mot de passe</label>
          <input type="password" id="password" placeholder="Entrer votre mot de passe" class="form-control" />
          <div class="invalid-feedback">Veuillez entrer un mot de passe valide.</div>
        </div>
        <div class="collapse" id="passwordCollapse">
          <div class="mb-3 form-group">
            <label class="form-label fw-medium" for="password_confirm">Confirmer le mot de passe</label>
            <input type="password" id="password_confirm" placeholder="Répéter le mot de passe" class="form-control" />
            <div class="invalid-feedback">Veuillez entrer un mot de passe valide.</div>
          </div>
        </div>
        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-primary fw-bold">S'inscrire</button>
        </div>
      </form>
      <p class="text-secondary text-center pt-1 pb-3">Vous avez déjà un compte? <a href="./connection.php">Se Connecter</a></p>
    </div>
  </div>
</div>

<script>
  const password = document.getElementById('password');
  const bsPasswordCollapse = new bootstrap.Collapse(document.getElementById('passwordCollapse'))

  password.addEventListener('input', () => {
    if (password.value.length > 0) {
      bsPasswordCollapse.show();
    } else {
      bsPasswordCollapse.hide();
    }
  });
</script>

<?php include_once __DIR__ . '/../../includes/layout/footer.php'; ?>

<!-- FIN PAGE -->
<?php end_page() ?>
<!-- /FIN PAGE -->
