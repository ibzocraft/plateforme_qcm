<?php
  require_once __DIR__ . '/../../../../includes/layout/page.php';
  require_once __DIR__ . '/../../../../includes/services/etudiant/etudiant.service.php';
  require_once __DIR__ . '/../../../../includes/services/utils/records.service.php';
  require_once __DIR__ . '/../../../../includes/services/utils/path.service.php';
  require_once __DIR__ . '/../../../../includes/services/utils/notification.service.php';
  require_once __DIR__ . '/../../../../includes/elements/module-header.php';

  if (!isset($_GET['id'])) redirect($_SERVER['HTTP_REFERER']);
  $etudiant = get_etudiant_by_id($_GET['id']);
  $resultats = recupererResultatsEtudiant($_GET['id']);
?>

<!-- DEBUT PAGE -->
<?php begin_page("Détail de l'étudiant - " . $etudiant['prenom'] . ' ' . $etudiant['nom']) ?>
<?php include_once __DIR__ . '/../../../../includes/layout/header_admin.php'; ?>
<!-- /DEBUT PAGE -->

<!-- CONTENU DE LA PAGE -->


<div class="container-fluid p-4" style="min-height: 100vh; margin-bottom: 5rem;">
  <!-- HEADER -->
  <?php module_header(
    $etudiant['prenom'] . ' ' . $etudiant['nom'],
    $etudiant['email']
  ); ?>
  <!-- /HEADER -->

  <div class="bg-theme rounded-4 p-3 py-4 overflow-hidden mb-3">
    <h4 class="text-custom-dark fs-22 fw-bold lh-tight px-4 mb-3">Informations Générales</h4>
    <div class="bg-theme-accent rounded mx-3 p-3">
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
  </div>

  <div class="bg-theme rounded-4 p-3 py-4 overflow-hidden">
    <h4 class="text-custom-dark fs-22 fw-bold lh-tight px-4 mb-3">Résultats sur les QCM</h4>
    <div class="bg-theme-accent rounded mx-3 p-3">
      <div class="table-container">
        <table class="table mb-0">
          <thead>
            <tr>
              <th class="mcq-col-title">QCM</th>
              <th class="mcq-col-score">Score</th>
              <th class="mcq-col-date">Date</th>
              <th class="mcq-col-status text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($resultats) > 0) : ?>
              <?php foreach ($resultats as $resultat) : ?>
                <tr>
                  <td class="text-custom-dark"><?= $resultat['titre'] ?></td>
                  <td class="course-col-progress">
                    <div class="d-flex align-items-center gap-3">
                      <?php $score_percent = ($resultat['score'] / 20) * 100; ?>
                      <div class="progress custom-progress" role="progressbar" aria-label="Course progress" aria-valuenow="<?= $score_percent ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: <?= $score_percent ?>%;"></div>
                      </div>
                      <p class="text-custom-dark fw-medium mb-0"><?= number_format($resultat['score'], 2) ?>/20</p>
                    </div>
                  </td>
                  <td class="mcq-col-date text-custom-secondary"><?= $resultat['date_passe'] ?></td>
                  <td class="text-center">
                    <a href="<?= "/pages/admin/qcms/detail-qcm.php?id=" . $resultat['qcm_id'] ?>" class="btn btn-dark text-decoration-none">
                      <span class="text-truncate">Voir le QCM <i class="bi bi-arrow-right"></i></span>
                    </a>
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
  </div>
  
  <div class="row justify-content-end mt-3">
    <div class="col-auto me-4">
      <a href="<?= "/pages/admin/etudiants/etudiants.php" ?>" role="button" class="btn btn-danger px-4">Quitter</a>
    </div>
  </div>
</div>

<!-- /CONTENU DE LA PAGE -->


<!-- FIN PAGE -->
<?php include_once __DIR__ . '/../../../../includes/layout/footer.php'; ?>
<?php end_page() ?>
<!-- /FIN PAGE -->
