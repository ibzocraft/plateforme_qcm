<?php
require_once __DIR__ . '/../db.php';

// Créer une note
function creerNote(int $utilisateur_id, string $matiere, float $valeur): int|false {
    $db = connectToDB();
    try {
        $sql = "INSERT INTO notes (utilisateur_id, matiere, valeur) VALUES (:utilisateur_id, :matiere, :valeur)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':utilisateur_id' => $utilisateur_id,
            ':matiere' => $matiere,
            ':valeur' => $valeur
        ]);
        return $db->lastInsertId();
    } catch (PDOException $e) {
        error_log('Erreur lors de la création de la note: ' . $e->getMessage());
        return false;
    }
}

// Modifier une note
function modifierNote(int $id, float $valeur): bool {
    $db = connectToDB();
    try {
        $sql = "UPDATE notes SET valeur = :valeur WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':valeur' => $valeur,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la modification de la note: ' . $e->getMessage());
        return false;
    }
}

// Supprimer une note
function supprimerNote(int $id): bool {
    $db = connectToDB();
    try {
        $sql = "DELETE FROM notes WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log('Erreur lors de la suppression de la note: ' . $e->getMessage());
        return false;
    }
}

// Récupérer toutes les notes d'un utilisateur
function recupererNotesParUtilisateur(int $utilisateur_id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM notes WHERE utilisateur_id = :utilisateur_id ORDER BY date_note DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([':utilisateur_id' => $utilisateur_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération des notes: ' . $e->getMessage());
        return false;
    }
}

// Récupérer une note par son ID
function recupererNoteParId(int $id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM notes WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération de la note: ' . $e->getMessage());
        return false;
    }
} 