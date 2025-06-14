<?php
require_once __DIR__ . '/../database/crud/qcm.php';
require_once __DIR__ . '/../services/core/functions.php';
require_once __DIR__ . '/../services/utils/path.php';

if (isset($_GET['add'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titre = $_POST['titre'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($titre)) {
            redirect_with_error(get_full_url('pages/admin/qcms/qcms.php'), 'Le titre est obligatoire.');
        }

        $result = creerQcm($titre, $description);

        if ($result) {
            redirect_with_success(get_full_url('pages/admin/qcms/qcms.php'), 'Le QCM a été ajouté avec succès.');
        } else {
            redirect_with_error(get_full_url('pages/admin/qcms/qcms.php'), 'Une erreur est survenue lors de l\'ajout du QCM.');
        }
    }
}

if (isset($_GET['edit'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? '';
        $titre = $_POST['titre'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($id) || empty($titre)) {
            redirect_with_error(get_full_url('pages/admin/qcms/qcms.php'), 'Les informations du QCM sont incomplètes.');
        }

        $result = modifierQcm($id, $titre, $description);

        if ($result) {
            redirect_with_success(get_full_url('pages/admin/qcms/qcms.php'), 'Le QCM a été modifié avec succès.');
        } else {
            redirect_with_error(get_full_url('pages/admin/qcms/qcms.php'), 'Une erreur est survenue lors de la modification du QCM.');
        }
    }
}

if (isset($_GET['delete'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            redirect_with_error(get_full_url('pages/admin/qcms/qcms.php'), 'L\'identifiant du QCM est manquant.');
        }

        $result = supprimerQcm($id);

        if ($result) {
            redirect_with_success(get_full_url('pages/admin/qcms/qcms.php'), 'Le QCM a été supprimé avec succès.');
        } else {
            redirect_with_error(get_full_url('pages/admin/qcms/qcms.php'), 'Une erreur est survenue lors de la suppression du QCM.');
        }
    }
} 