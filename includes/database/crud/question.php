<?php
require_once __DIR__ . '/../db.php';

// Créer une question
function creerQuestion(int $qcm_id, string $texte_question): int|false {
    $db = connectToDB();
    try {
        $sql = "INSERT INTO questions (qcm_id, texte_question) VALUES (:qcm_id, :texte_question)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':qcm_id' => $qcm_id,
            ':texte_question' => $texte_question
        ]);
        return $db->lastInsertId();
    } catch (PDOException $e) {
        error_log('Erreur lors de la création de la question: ' . $e->getMessage());
        return false;
    }
}

// Modifier une question
function modifierQuestion(int $id, string $texte_question): bool {
    $db = connectToDB();
    try {
        $sql = "UPDATE questions SET texte_question = :texte_question WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':texte_question' => $texte_question,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la modification de la question: ' . $e->getMessage());
        return false;
    }
}

// Supprimer une question
function supprimerQuestion(int $id): bool {
    $db = connectToDB();
    try {
        $sql = "DELETE FROM questions WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la suppression de la question: ' . $e->getMessage());
        return false;
    }
}

// Récupérer toutes les questions d'un QCM
function recupererQuestionsParQcm(int $qcm_id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM questions WHERE qcm_id = :qcm_id ORDER BY id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':qcm_id' => $qcm_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération des questions: ' . $e->getMessage());
        return false;
    }
}

// Récupérer une question par son ID
function recupererQuestionParId(int $id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM questions WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération de la question: ' . $e->getMessage());
        return false;
    }
} 