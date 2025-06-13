<?php

require_once __DIR__."/../services/core/auth.php";
require_once __DIR__."/../services/utils/path.php";
require_once __DIR__."/../services/utils/api.php";

// login
if (isset($_GET['login'])) {
    if (!check_required_fields(['email', 'password'])) {
        redirect_with_error(get_full_url("pages/auth/connection.php"), "Le formulaire est incomplet");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = login($email, $password);
    if ($user) {
        if ($user['role'] == 'admin')
            redirect(get_full_url("pages/admin/dashboard.php"));
        else
            redirect(get_full_url("pages/portail/dashboard.php"));
    } else {
        redirect_with_error(get_full_url("pages/auth/connection.php"), "Vos identifiants sont incorrects");
    }
}

// logout
if (isset($_GET['logout'])) {
    logout();
}
