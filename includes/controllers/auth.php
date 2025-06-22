<?php

require_once __DIR__."/../services/core/auth.service.php";
require_once __DIR__."/../services/utils/path.service.php";
require_once __DIR__."/../services/core/controller.service.php";

init_controller_group("/auth");

// login
register_controller("POST", "/login", function() {
    if (!check_required_fields(['email', 'password'])) {
        redirect_with_error("/pages/auth/connection.php", "Le formulaire est incomplet");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = login($email, $password);
    if ($user) {
        if ($user['role'] == 'admin')
            redirect_with_success("/pages/admin/dashboard.php", "Vous êtes connecté en tant qu'administrateur !");
        else
            redirect_with_success("/pages/portail/dashboard.php", "Vous êtes connecté en tant qu'étudiant !");
    } else {
        redirect_with_error("/pages/auth/connection.php", "Vos identifiants sont incorrects");
    }
});


// signup
register_controller("POST", "/signup", function() {
    if (!check_required_fields(['email', 'password', 'password_confirm', 'nom', 'prenom', 'classe'])) {
        redirect_with_error("/pages/auth/inscription.php", "Le formulaire est incomplet");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $classe = $_POST['classe'];
    
    if ($password != $password_confirm) {
        redirect_with_error("/pages/auth/inscription.php", "Les mots de passe ne correspondent pas");
    }

    $user = signup($email, $password, $nom, $prenom, $classe);
    if ($user) {
        $logged = login($email, $password);
        if ($logged) {
                redirect_with_success("/pages/portail/dashboard.php", "Inscription réussie, vous êtes maintenant connecté !");
        } else {
            redirect_with_error("/pages/auth/connection.php", "Inscription réussie, mais une erreur est survenue lors de la connexion");
        }
    } else {
        redirect_with_error("/pages/auth/inscription.php", "Une erreur est survenue lors de l'inscription");
    }
});

// logout
register_controller("GET", "/logout", fn() => logout());

