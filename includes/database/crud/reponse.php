<?php
require_once __DIR__ . '/../db.php';

// Créer une réponse
function creerReponse(int $question_id, string $texte_reponse, bool $est_correcte = false): int|false {
    $db = connectToDB();
    try {
        $sql = "INSERT INTO reponses (question_id, texte_reponse, est_correcte) VALUES (:question_id, :texte_reponse, :est_correcte)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':question_id' => $question_id,
            ':texte_reponse' => $texte_reponse,
            ':est_correcte' => $est_correcte
        ]);
        return $db->lastInsertId();
    } catch (PDOException $e) {
        error_log('Erreur lors de la création de la réponse: ' . $e->getMessage());
        return false;
    }
}

// Modifier une réponse
function modifierReponse(int $id, string $texte_reponse, bool $est_correcte = false): bool {
    $db = connectToDB();
    try {
        $sql = "UPDATE reponses SET texte_reponse = :texte_reponse, est_correcte = :est_correcte WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':texte_reponse' => $texte_reponse,
            ':est_correcte' => $est_correcte,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la modification de la réponse: ' . $e->getMessage());
        return false;
    }
}

// Supprimer une réponse
function supprimerReponse(int $id): bool {
    $db = connectToDB();
    try {
        $sql = "DELETE FROM reponses WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la suppression de la réponse: ' . $e->getMessage());
        return false;
    }
}

// Récupérer toutes les réponses d'une question
function recupererReponsesParQuestion(int $question_id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM reponses WHERE question_id = :question_id ORDER BY id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':question_id' => $question_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération des réponses: ' . $e->getMessage());
        return false;
    }
}

// Récupérer une réponse par son ID
function recupererReponseParId(int $id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM reponses WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération de la réponse: ' . $e->getMessage());
        return false;
    }
} 