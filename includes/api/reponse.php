<?php
require_once __DIR__ . '/../database/crud/reponse.php';
require_once __DIR__ . '/../services/core/functions.php';
require_once __DIR__ . '/../services/utils/path.php';

if (isset($_GET['add'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $qcm_id = $_GET['qcm_id'] ?? '';
        $question_id = $_POST['question_id'] ?? '';
        $texte_reponse = $_POST['texte_reponse'] ?? '';
        $est_correcte = isset($_POST['est_correcte']) ? 1 : 0;

        $redirect_url = get_full_url('pages/admin/qcms/detail-qcm.php?id=' . $qcm_id);

        if (empty($question_id) || empty($texte_reponse) || empty($qcm_id)) {
            redirect_with_error($redirect_url, 'Les informations de la réponse sont incomplètes.');
        }

        $result = creerReponse($question_id, $texte_reponse, $est_correcte);

        if ($result) {
            redirect_with_success($redirect_url, 'La réponse a été ajoutée avec succès.');
        } else {
            redirect_with_error($redirect_url, 'Une erreur est survenue lors de l\'ajout de la réponse.');
        }
    }
}

if (isset($_GET['edit'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $qcm_id = $_GET['qcm_id'] ?? '';
        $reponse_id = $_POST['reponse_id'] ?? '';
        $texte_reponse = $_POST['texte_reponse'] ?? '';
        $est_correcte = isset($_POST['est_correcte']) ? 1 : 0;

        $redirect_url = get_full_url('pages/admin/qcms/detail-qcm.php?id=' . $qcm_id);

        if (empty($qcm_id) || empty($reponse_id) || empty($texte_reponse)) {
            redirect_with_error($redirect_url, 'Les informations de la réponse sont incomplètes.');
        }

        $result = modifierReponse($reponse_id, $texte_reponse, $est_correcte);

        if ($result) {
            redirect_with_success($redirect_url, 'La réponse a été modifiée avec succès.');
        } else {
            redirect_with_error($redirect_url, 'Une erreur est survenue lors de la modification de la réponse.');
        }
    }
}

if (isset($_GET['delete'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $qcm_id = $_GET['qcm_id'] ?? '';
        $reponse_id = $_POST['reponse_id'] ?? '';

        $redirect_url = get_full_url('pages/admin/qcms/detail-qcm.php?id=' . $qcm_id);

        if (empty($qcm_id) || empty($reponse_id)) {
            redirect_with_error($redirect_url, 'L\'identifiant de la réponse est manquant.');
        }

        $result = supprimerReponse($reponse_id);

        if ($result) {
            redirect_with_success($redirect_url, 'La réponse a été supprimée avec succès.');
        } else {
            redirect_with_error($redirect_url, 'Une erreur est survenue lors de la suppression de la réponse.');
        }
    }
} 