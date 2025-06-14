<?php
require_once __DIR__ . '/../database/crud/utilisateur.php';
require_once __DIR__ . '/../services/core/functions.php';
require_once __DIR__ . '/../services/core/auth.php';
require_once __DIR__ . '/../services/utils/path.php';

$redirect_url = get_full_url('pages/portail/profil.php');

if (isset($_GET['update_info'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student = get_authenticated_user();
        if (!$student) {
            redirect_with_error($redirect_url, 'Utilisateur non authentifié.');
        }

        $prenom = $_POST['prenom'] ?? '';
        $nom = $_POST['nom'] ?? '';
        $email = $_POST['email'] ?? '';

        if (empty($prenom) || empty($nom) || empty($email)) {
            redirect_with_error($redirect_url, 'Veuillez remplir tous les champs.');
        }

        $data = [
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email
        ];

        $result = modifierUtilisateur($student['id'], $data);

        if ($result) {
            // Refresh session data
            $_SESSION['user'] = array_merge($_SESSION['user'], $data);
            redirect_with_success($redirect_url, 'Profil mis à jour avec succès.');
        } else {
            redirect_with_error($redirect_url, 'Erreur lors de la mise à jour du profil.');
        }
    }
}

if (isset($_GET['update_password'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student = get_authenticated_user();
        if (!$student) {
            redirect_with_error($redirect_url, 'Utilisateur non authentifié.');
        }

        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            redirect_with_error($redirect_url, 'Veuillez remplir tous les champs.');
        }

        if ($new_password !== $confirm_password) {
            redirect_with_error($redirect_url, 'Le nouveau mot de passe et sa confirmation ne correspondent pas.');
        }

        // Verify current password
        if (!password_verify($current_password, $student['mot_de_passe'])) {
            redirect_with_error($redirect_url, 'Le mot de passe actuel est incorrect.');
        }

        $data = ['mot_de_passe' => $new_password];
        $result = modifierUtilisateur($student['id'], $data);

        if ($result) {
            redirect_with_success($redirect_url, 'Mot de passe mis à jour avec succès.');
        } else {
            redirect_with_error($redirect_url, 'Erreur lors de la mise à jour du mot de passe.');
        }
    }
} 