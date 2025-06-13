<?php
require_once __DIR__."/../../database/crud/utilisateur.php";
require_once __DIR__."/../../services/core/functions.php";

session_start();
function login($email, $password): array|false {
    $user = verifyUtilisateurCredentials($email, $password);
    if($user) {
        $_SESSION["user"] = $user;
        return $user;
    }
    return false;
}

/**
 * Vérifie les identifiants de connexion d'un utilisateur
 * @param string $email Email de l'utilisateur
 * @param string $password Mot de passe de l'utilisateur
 * @return array|false Les données de l'utilisateur si les identifiants sont corrects, false sinon
 */
function verifyUtilisateurCredentials(string $email, string $password): array|false {
    $utilisateur = recupererUtilisateurParEmail($email);
    if ($utilisateur && password_verify($password, $utilisateur['mot_de_passe'])) {
        return $utilisateur;
    }
    return false;
}


function is_authenticated() {
    return isset($_SESSION["user"]);
}

function get_authenticated_user() {
    return $_SESSION["user"] ?? null;
}

function is_admin() {
    return get_authenticated_user()['role'] == 'admin';
}

function logout() {
    unset($_SESSION["user"]);
    session_destroy();
    redirect(get_full_url("pages/auth/connection.php"));
}
