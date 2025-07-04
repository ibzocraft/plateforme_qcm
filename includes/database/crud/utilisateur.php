<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../../services/core/functions.service.php';

/**
 * Ajoute un nouvel étudiant dans la base de données
 * @param string $numero_etudiant Numéro d'étudiant
 * @param string $prenom Prénom de l'étudiant
 * @param string $nom Nom de l'étudiant
 * @param string $email Email de l'étudiant
 * @param string $motdepasse Mot de passe de l'étudiant
 * @return int|false L'ID de l'étudiant créé ou false en cas d'échec
 */
function ajouterUtilisateur(string $numero_etudiant, string $prenom, string $nom, string $email, string $motdepasse, string $classe, string $role): array|false {
    $db = connectToDB();
    try {
        $sql = "INSERT INTO utilisateurs (numero_etudiant, prenom, nom, email, mot_de_passe, role, classe) VALUES (:numero_etudiant, :prenom, :nom, :email, :mot_de_passe, :role, :classe)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':numero_etudiant' => $numero_etudiant,
            ':prenom' => $prenom,
            ':nom' => $nom,
            ':email' => $email,
            ':mot_de_passe' => password_hash($motdepasse, PASSWORD_DEFAULT),
            ':role' => $role,
            ':classe' => $classe
        ]);
        // return $db->lastInsertId();
        return recupererUtilisateurParId($db->lastInsertId());
    } catch (PDOException $e) {
        error_log("Erreur lors de l'ajout de l'étudiant: " . $e->getMessage());
        return false;
    }
}

/**
 * Modifie les informations d'un étudiant
 * @param int $id ID de l'étudiant
 * @param string $prenom Prénom de l'étudiant
 * @param string $nom Nom de l'étudiant
 * @param string $email Email de l'étudiant
 * @param string $motdepasse Mot de passe de l'étudiant
 * @return bool True si la modification a réussi, false sinon
 */
function modifierUtilisateur(int $id, array $data): bool {
    $db = connectToDB();

    $allowedFields = ['email', 'mot_de_passe', 'role', 'nom', 'prenom', 'classe'];
    $updates = [];
    $params = [':id' => $id];

    foreach ($data as $key => $value) {
        if (in_array($key, $allowedFields) && $value !== null) {
            if ($key === 'mot_de_passe') {
                $updates[] = "$key = :$key";
                $params[":$key"] = password_hash($value, PASSWORD_DEFAULT);
            } else {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }
    }

    if (empty($updates)) return false;
    
    try {
        $sql = "UPDATE utilisateurs SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log("Erreur lors de la modification de l'étudiant: " . $e->getMessage());
        return false;
    }
}

/**
 * Supprime un étudiant
 * @param int $id ID de l'étudiant à supprimer
 * @return bool True si la suppression a réussi, false sinon
 */
function supprimerUtilisateur(int $id): bool {
    $db = connectToDB();
    try {
        $sql = "DELETE FROM utilisateurs WHERE id = :id AND role = 'etudiant'";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression de l'étudiant: " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère la liste de tous les étudiants
 * @return array|false Liste des étudiants ou false en cas d'erreur
 */
function recupererUtilisateurs(): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM utilisateurs ORDER BY date_inscription DESC, nom, prenom, classe";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des étudiants: " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère la liste de tous les étudiants
 * @return array|false Liste des étudiants ou false en cas d'erreur
 */
function recupererUtilisateursParRole(string $role): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM utilisateurs WHERE role = :role ORDER BY date_inscription DESC, nom, prenom, classe";
        $stmt = $db->prepare($sql);
        $stmt->execute([':role' => $role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des étudiants: " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère un étudiant par son ID
 * @param int $id ID de l'étudiant
 * @return array|false Les données de l'étudiant ou false si non trouvé
 */
function recupererUtilisateurParId(int $id): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM utilisateurs WHERE id = :id AND role = 'etudiant'";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de l'étudiant: " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère un étudiant par son email
 * @param string $email Email de l'étudiant
 * @return array|false Les données de l'étudiant ou false si non trouvé
 */
function recupererUtilisateurParEmail(string $email): array|false {
    $db = connectToDB();
    try {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de l'utilisateur par email: " . $e->getMessage());
        return false;
    }
}

function recupererDernierIdUtilisateur() {
    $db = connectToDB();
    try {
        $sql = "SELECT MAX(id) FROM utilisateurs";
        $stmt = $db->query($sql);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de l'utilisateur par email: " . $e->getMessage());
        return false;
    }
}

function countUtilisateursParRole(string $role): int {
    $db = connectToDB();
    try {
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE role = :role";
        $stmt = $db->prepare($sql);
        $stmt->execute([':role' => $role]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Erreur lors du comptage des utilisateurs: " . $e->getMessage());
        return 0;
    }
}

function getNouveauxInscritsParMois(int $nb_mois = 6): array {
    $db = connectToDB();
    try {
        $sql = "SELECT DATE_FORMAT(date_inscription, '%Y-%m') as mois, COUNT(*) as count 
                FROM utilisateurs 
                WHERE role = 'etudiant' AND date_inscription >= CURDATE() - INTERVAL :nb_mois MONTH 
                GROUP BY mois 
                ORDER BY mois ASC";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nb_mois', $nb_mois, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération des nouveaux inscrits: ' . $e->getMessage());
        return [];
    }
}

function getRepartionEtudiantsParClasse(): array {
    $db = connectToDB();
    try {
        $sql = "SELECT classe, COUNT(*) as count 
                FROM utilisateurs 
                WHERE role = 'etudiant' AND classe IS NOT NULL
                GROUP BY classe";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Erreur lors de la récupération de la répartition par classe: ' . $e->getMessage());
        return [];
    }
}

function countNouveauxUtilisateursEntreJours(string $role, int $debut_jours_avant, int $fin_jours_avant): int {
    $db = connectToDB();
    try {
        $sql = "SELECT COUNT(*) FROM utilisateurs 
                WHERE role = :role AND date_inscription >= CURDATE() - INTERVAL :debut_jours_avant DAY 
                AND date_inscription < CURDATE() - INTERVAL (:fin_jours_avant - 1) DAY";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':role' => $role,
            ':debut_jours_avant' => $debut_jours_avant,
            ':fin_jours_avant' => $fin_jours_avant
        ]);
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Erreur lors du comptage des nouveaux utilisateurs: " . $e->getMessage());
        return 0;
    }
}