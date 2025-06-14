<?php
require_once __DIR__ . '/../db.php';

// Créer un résultat
function creerResultat(int $utilisateur_id, int $qcm_id, float $score): int|false {
    $db = connectToDB();
    try {
        $sql = "INSERT INTO resultats (utilisateur_id, qcm_id, score) VALUES (:utilisateur_id, :qcm_id, :score)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':utilisateur_id' => $utilisateur_id,
            ':qcm_id' => $qcm_id,
            ':score' => $score
        ]);
        return $db->lastInsertId();
    } catch (PDOException $e) {
        error_log('Erreur lors de la création du résultat: ' . $e->getMessage());
        return false;
    }
}

// Modifier un résultat
function modifierResultat(int $id, float $score): bool {
    $db = connectToDB();
    try {
        $sql = "UPDATE resultats SET score = :score WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':score' => $score,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la modification du résultat: ' . $e->getMessage());
        return false;
    }
}

// Supprimer un résultat
function supprimerResultat(int $id): bool {
    $db = connectToDB();
    try {
        $sql = "DELETE FROM resultats WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la suppression du résultat: ' . $e->getMessage());
        return false;
    }
}

// Récupérer tous les résultats d'un utilisateur
function recupererResultatsParUtilisateur(int $utilisateur_id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT resultats.*, qcms.titre FROM resultats 
        JOIN qcms ON resultats.qcm_id = qcms.id 
        WHERE resultats.utilisateur_id = :utilisateur_id 
        ORDER BY resultats.date_passe DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([':utilisateur_id' => $utilisateur_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération des résultats: ' . $e->getMessage());
        return false;
    }
}

// Récupérer un résultat par son ID
function recupererResultatParId(int $id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM resultats WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération du résultat: ' . $e->getMessage());
        return false;
    }
} 


function recupererDerniersResultats(int $limit = 5): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT resultats.*, utilisateurs.nom, utilisateurs.prenom, qcms.titre 
                FROM resultats 
                JOIN utilisateurs ON resultats.utilisateur_id = utilisateurs.id 
                JOIN qcms ON resultats.qcm_id = qcms.id 
                ORDER BY resultats.date_passe DESC 
                LIMIT :limit";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération des résultats: ' . $e->getMessage());
        return false;
    }
}

function countResultats(): int {
    $db = connectToDB();
    try {
        $sql = "SELECT COUNT(*) FROM resultats";
        $stmt = $db->query($sql);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('Erreur lors du comptage des résultats: ' . $e->getMessage());
        return 0;
    }
}

function getAverageScore(): float {
    $db = connectToDB();
    try {
        $sql = "SELECT AVG(score) FROM resultats";
        $stmt = $db->query($sql);
        return $stmt->fetchColumn() ?: 0.0;
    } catch (PDOException $e) {
        error_log('Erreur lors du calcul du score moyen: ' . $e->getMessage());
        return 0.0;
    }
}

function getActiviteQcmParJour(int $nb_jours = 7): array {
    $db = connectToDB();
    try {
        $sql = "SELECT DATE(date_passe) as jour, COUNT(*) as count 
                FROM resultats 
                WHERE date_passe >= CURDATE() - INTERVAL :nb_jours DAY 
                GROUP BY jour 
                ORDER BY jour ASC";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nb_jours', $nb_jours, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération de l\'activité QCM: ' . $e->getMessage());
        return [];
    }
}

function countParticipationsEntreJours(int $debut_jours_avant, int $fin_jours_avant): int {
    $db = connectToDB();
    try {
        $sql = "SELECT COUNT(*) FROM resultats 
                WHERE date_passe >= CURDATE() - INTERVAL :debut_jours_avant DAY 
                AND date_passe < CURDATE() - INTERVAL (:fin_jours_avant - 1) DAY";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':debut_jours_avant' => $debut_jours_avant,
            ':fin_jours_avant' => $fin_jours_avant
        ]);
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Erreur lors du comptage des participations: " . $e->getMessage());
        return 0;
    }
}

function getAverageScoreEntreJours(int $debut_jours_avant, int $fin_jours_avant): float {
    $db = connectToDB();
    try {
        $sql = "SELECT AVG(score) FROM resultats 
                WHERE date_passe >= CURDATE() - INTERVAL :debut_jours_avant DAY 
                AND date_passe < CURDATE() - INTERVAL (:fin_jours_avant - 1) DAY";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':debut_jours_avant' => $debut_jours_avant,
            ':fin_jours_avant' => $fin_jours_avant
        ]);
        $avg_score = $stmt->fetchColumn() ?: 0.0;
        
        // The score is out of 100 in the DB, so we convert it to be out of 20
        return ($avg_score / 100) * 20;

    } catch (PDOException $e) {
        error_log("Erreur lors du calcul du score moyen: " . $e->getMessage());
        return 0.0;
    }
}