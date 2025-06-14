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