<?php
require_once __DIR__ . '/../database/crud/resultat.php';
require_once __DIR__ . '/../database/crud/reponse.php';
require_once __DIR__ . '/../database/crud/question.php';
require_once __DIR__ . '/../services/core/functions.php';
require_once __DIR__ . '/../services/core/auth.php';
require_once __DIR__ . '/../services/utils/path.php';

if (isset($_GET['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student = get_authenticated_user();
        $qcm_id = $_POST['qcm_id'] ?? null;
        $submitted_reponses = $_POST['reponses'] ?? [];

        if (!$student || !$qcm_id || empty($submitted_reponses)) {
            redirect_with_error(get_full_url('pages/portail/qcms/qcms.php'), 'Une erreur est survenue. Veuillez réessayer.');
        }

        $questions = recupererQuestionsParQcm($qcm_id);
        if (!$questions) {
            redirect_with_error(get_full_url('pages/portail/qcms/qcms.php'), 'Ce QCM ne contient aucune question.');
        }

        $correct_answers_count = 0;
        foreach ($questions as $question) {
            $question_id = $question['id'];
            if (isset($submitted_reponses[$question_id])) {
                $reponse_id = $submitted_reponses[$question_id];
                $reponse = recupererReponseParId($reponse_id);
                if ($reponse && $reponse['est_correcte']) {
                    $correct_answers_count++;
                }
            }
        }

        $total_questions = count($questions);
        $score = ($correct_answers_count / $total_questions) * 20;

        $result = creerResultat($student['id'], $qcm_id, $score);

        if ($result) {
            redirect_with_success(get_full_url('pages/portail/dashboard.php'), "QCM terminé ! Votre score est de " . number_format($score, 2) . "/20.");
        } else {
            redirect_with_error(get_full_url('pages/portail/qcms/qcms.php?id=' . $qcm_id), 'Erreur lors de l\'enregistrement de votre score.');
        }
    }
} 