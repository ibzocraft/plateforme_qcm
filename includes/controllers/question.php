<?php
require_once __DIR__ . '/../database/crud/question.php';
require_once __DIR__.'/../services/utils/path.service.php';
require_once __DIR__.'/../services/core/controller.service.php';

init_controller_group("/question");

// add
register_controller("POST", "/add", function() {
    $qcm_id = $_POST['qcm_id'] ?? '';
    $texte_question = $_POST['texte_question'] ?? '';

    if (empty($qcm_id) || empty($texte_question)) {
        redirect_with_error('/pages/admin/qcms/detail-qcm.php?id=' . $qcm_id, 'Le texte de la question est obligatoire.');
    }

    $result = creerQuestion($qcm_id, $texte_question);

    if ($result) {
        redirect_with_success('/pages/admin/qcms/detail-qcm.php?id=' . $qcm_id, 'La question a été ajoutée avec succès.');
    } else {
        redirect_with_error('/pages/admin/qcms/detail-qcm.php?id=' . $qcm_id, 'Une erreur est survenue lors de l\'ajout de la question.');
    }
});

// edit
register_controller("POST", "/edit", function() {
    $qcm_id = $_GET['qcm_id'] ?? '';
    $question_id = $_POST['question_id'] ?? '';
    $texte_question = $_POST['texte_question'] ?? '';

    $redirect_url = '/pages/admin/qcms/detail-qcm.php?id=' . $qcm_id;

    if (empty($qcm_id) || empty($question_id) || empty($texte_question)) {
        redirect_with_error($redirect_url, 'Les informations de la question sont incomplètes.');
    }

    $result = modifierQuestion($question_id, $texte_question);

    if ($result) {
        redirect_with_success($redirect_url, 'La question a été modifiée avec succès.');
    } else {
        redirect_with_error($redirect_url, 'Une erreur est survenue lors de la modification de la question.');
    }
});

// delete
register_controller("POST", "/delete", function() {
    $qcm_id = $_GET['qcm_id'] ?? '';
    $question_id = $_POST['question_id'] ?? '';

    $redirect_url = '/pages/admin/qcms/detail-qcm.php?id=' . $qcm_id;

    if (empty($qcm_id) || empty($question_id)) {
        redirect_with_error($redirect_url, 'L\'identifiant de la question est manquant.');
    }

    $result = supprimerQuestion($question_id);

    if ($result) {
        redirect_with_success($redirect_url, 'La question a été supprimée avec succès.');
    } else {
        redirect_with_error($redirect_url, 'Une erreur est survenue lors de la suppression de la question.');
    }
}); 