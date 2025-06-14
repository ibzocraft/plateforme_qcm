<?php
  require_once __DIR__ . '/../../../includes/layout/page.php';
  require_once __DIR__ . '/../../../includes/services/etudiant/etudiant.service.php';
  require_once __DIR__ . '/../../../includes/services/utils/records.php';
  require_once __DIR__ . '/../../../includes/services/utils/path.php';
  require_once __DIR__ . '/../../../includes/services/utils/notification.php';

  if (!isset($_GET['id'])) redirect($_SERVER['HTTP_REFERER']);
  $etudiant = get_etudiant_by_id($_GET['id']);
  $resultats = recupererResultatsEtudiant($_GET['id']);
?>

<!-- DEBUT PAGE -->
<?php begin_page("Détail de l'étudiant - " . $etudiant['prenom'] . ' ' . $etudiant['nom']) ?>
<?php include_once __DIR__ . '/../../../includes/layout/header_admin.php'; ?>
<!-- /DEBUT PAGE -->

<!-- CONTENU DE LA PAGE -->

<style>
  /* Définition des propriétés personnalisées pour le thème clair, correspondant aux couleurs originales de Tailwind.
     Celles-ci sont ensuite surchargées pour le thème sombre en utilisant le sélecteur [data-bs-theme="dark"].
  */
  :root {
    --custom-text-dark: #111518;
    --custom-text-secondary: #60768a;
    --custom-border-color: #dbe1e6;
    --custom-bg-light: #f0f2f5;
    --custom-bg-body: #f8fafc;
  }

  [data-bs-theme="dark"] {
    --custom-text-dark: var(--bs-body-color);
    --custom-text-secondary: var(--bs-secondary-color);
    --custom-border-color: var(--bs-border-color-translucent);
    --custom-bg-light: var(--bs-tertiary-bg);
    --custom-bg-body: var(--bs-body-bg);
  }
  
  body {
    background-color: var(--custom-bg-body);
  }

  .layout-container {
    max-width: 960px;
    margin-left: auto;
    margin-right: auto;
  }

  /* Texte personnalisé utilisant des variables compatibles avec les thèmes */
  .text-custom-dark { color: var(--custom-text-dark); }
  .text-custom-secondary { color: var(--custom-text-secondary); }

  /* Tailles de police personnalisées */
  .fs-22 { font-size: 22px; }
  .fs-32 { font-size: 32px; }

  /* Taille de l'image de profil */
  .profile-img {
    width: 8rem; /* 128px */
    height: 8rem; /* 128px */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  /* Bouton personnalisé compatible avec les thèmes */
  .btn-status {
    --bs-btn-bg: var(--custom-bg-light);
    --bs-btn-color: var(--custom-text-dark);
    --bs-btn-border-color: var(--custom-bg-light);
    --bs-btn-hover-bg: color-mix(in srgb, var(--custom-bg-light) 90%, black);
    --bs-btn-hover-border-color: color-mix(in srgb, var(--custom-bg-light) 90%, black);
    --bs-btn-hover-color: var(--custom-text-dark);
    min-width: 84px;
  }
  
  /* Conteneur de tableau personnalisé compatible avec les thèmes */
  .table-container {
    border: 1px solid var(--custom-border-color);
    border-radius: 0.75rem;
    overflow: hidden;
  }

  .table-container .table {
    --bs-table-bg: var(--bs-body-bg);
    --bs-table-striped-bg: var(--bs-secondary-bg);
  }
  
  .table-container .table > :not(caption) > * > * {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    vertical-align: middle;
    height: 72px;
  }
  
  .table-container .table thead th {
    color: var(--custom-text-dark);
    font-weight: 500;
  }

  .table-container .table tbody tr {
    border-top: 1px solid var(--custom-border-color);
  }
  
  /* Barre de progression personnalisée compatible avec les thèmes */
  .progress.custom-progress {
    width: 88px;
    background-color: var(--custom-border-color);
    height: 0.25rem;
  }

  .progress.custom-progress .progress-bar {
    background-color: var(--custom-text-dark);
  }

  /* Requêtes de conteneur pour les tableaux réactifs (non affectées par le thème) */
  .responsive-table-wrapper {
    container-type: inline-size;
  }
  
  @container (max-width: 480px) { .course-col-progress, .mcq-col-date { display: none !important; } }
  @container (max-width: 360px) { .course-col-status { display: none !important; } }
  @container (max-width: 240px) { .course-col-instructor, .mcq-col-score { display: none !important; } }

</style>

<div class="layout-container d-flex flex-column flex-grow-1 pt-5 pb-5" style="min-height: 100vh; margin-bottom: 5rem;">
  <div class="d-flex flex-wrap justify-content-between gap-3 p-4">
    <div class="d-flex flex-row justify-content-between gap-3 w-100" style="min-width: 18rem;">
      <h1 class="text-custom-dark fw-bold fs-32 lh-tight">Détails de l'étudiant</h1>
    </div>
  </div>
  
  <div class="p-4">
    <div class="d-flex w-100 flex-column gap-4 flex-md-row justify-content-md-between align-items-md-center">
      <div class="d-flex gap-4">
        <div class="profile-img rounded-circle" style='background-image: url("<?= echo_full_url('assets/images/profile-pic.png') ?>");'></div>
        <div class="d-flex flex-column justify-content-center">
          <p class="text-custom-dark fs-22 fw-bold lh-tight"><?= $etudiant['prenom'] . ' ' . $etudiant['nom'] ?></p>
          <p class="text-custom-secondary"><?= $etudiant['email'] ?></p>
        </div>
      </div>
    </div>
  </div>

  <h2 class="text-custom-dark fs-22 fw-bold lh-tight px-4 pb-3 pt-5">Informations Générales</h2>
  <div class="px-4 py-3 responsive-table-wrapper">
    <div class="table-container">
      <table class="table mb-0">
        <thead>
          <tr>
            <th class="course-col-progress">Numéro d'étudiant</th>
            <th class="course-col-instructor">Email</th>
            <th class="course-col-status">Classe</th>
            <th class="course-col-status">Date d'inscription</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-custom-secondary"><?= $etudiant['numero_etudiant'] ?></td>
            <td class="text-custom-secondary"><?= $etudiant['email'] ?></td>
            <td class="text-custom-secondary"><?= $etudiant['classe'] ?></td>
            <td class="text-custom-secondary"><?= $etudiant['date_inscription'] ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <h2 class="text-custom-dark fs-22 fw-bold lh-tight px-4 pb-3 pt-5">Résultats sur les QCM</h2>
  <div class="px-4 py-3 responsive-table-wrapper">
    <div class="table-container">
      <table class="table mb-0">
        <thead>
          <tr>
            <th class="mcq-col-title">QCM</th>
            <th class="mcq-col-score">Score</th>
            <th class="mcq-col-date">Date</th>
            <th class="mcq-col-status">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($resultats) > 0) : ?>
            <?php foreach ($resultats as $resultat) : ?>
              <tr>
                <td class="text-custom-dark"><?= $resultat['titre'] ?></td>
                <td class="course-col-progress">
                  <div class="d-flex align-items-center gap-3">
                    <div class="progress custom-progress" role="progressbar" aria-label="Course progress" aria-valuenow="<?= $resultat['score'] ?>" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar" style="width: <?= $resultat['score'] ?>%;"></div>
                    </div>
                    <p class="text-custom-dark fw-medium mb-0"><?= intval($resultat['score']) ?>%</p>
                  </div>
                </td>
                <td class="mcq-col-date text-custom-secondary"><?= $resultat['date_passe'] ?></td>
                <td class="course-col-status">
                  <button class="btn btn-status rounded-pill w-100">
                    <span class="text-truncate">Voir le QCM</span>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4" class="text-center">Aucun résultat trouvé</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <div class="row justify-content-end mt-3">
    <div class="col-auto me-4">
      <a href="<?= echo_full_url('pages/admin/etudiants/etudiants.php') ?>" role="button" class="btn btn-danger px-4">Quitter</a>
    </div>
  </div>
</div>

<!-- /CONTENU DE LA PAGE -->


<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../includes/layout/footer.php'; ?>
<?php end_page() ?>
<!-- /FIN PAGE -->
