<?php
require_once __DIR__ . '/../db.php';

// Créer un QCM
function creerQcm(string $titre, string $description = ""): int|false {
    $db = connectToDB();
    try {
        $sql = "INSERT INTO qcms (titre, description) VALUES (:titre, :description)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':titre' => $titre,
            ':description' => $description
        ]);
        return $db->lastInsertId();
    } catch (PDOException $e) {
        error_log('Erreur lors de la création du QCM: ' . $e->getMessage());
        return false;
    }
}

// Modifier un QCM
function modifierQcm(int $id, string $titre, string $description = ""): bool {
    $db = connectToDB();
    try {
        $sql = "UPDATE qcms SET titre = :titre, description = :description WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':titre' => $titre,
            ':description' => $description,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la modification du QCM: ' . $e->getMessage());
        return false;
    }
}

// Supprimer un QCM
function supprimerQcm(int $id): bool {
    $db = connectToDB();
    try {
        $sql = "DELETE FROM qcms WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la suppression du QCM: ' . $e->getMessage());
        return false;
    }
}

// Récupérer tous les QCMs
function recupererQcms(): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM qcms ORDER BY titre";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération des QCMs: ' . $e->getMessage());
        return false;
    }
}

// Récupérer un QCM par son ID
function recupererQcmParId(int $id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM qcms WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération du QCM: ' . $e->getMessage());
        return false;
    }
}

function countQcms(): int {
    $db = connectToDB();
    try {
        $sql = "SELECT COUNT(*) FROM qcms";
        $stmt = $db->query($sql);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('Erreur lors du comptage des QCMs: ' . $e->getMessage());
        return 0;
    }
}

function countQcmsCreesEntreJours(int $debut_jours_avant, int $fin_jours_avant): int {
    $db = connectToDB();
    try {
        $sql = "SELECT COUNT(*) FROM qcms 
                WHERE date_creation >= CURDATE() - INTERVAL :debut_jours_avant DAY 
                AND date_creation < CURDATE() - INTERVAL (:fin_jours_avant - 1) DAY";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':debut_jours_avant' => $debut_jours_avant,
            ':fin_jours_avant' => $fin_jours_avant
        ]);
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Erreur lors du comptage des QCMs créés: " . $e->getMessage());
        return 0;
    }
} 
