<?php

require_once __DIR__."/../services/etudiant/etudiant.service.php";
require_once __DIR__."/../services/utils/path.php";
require_once __DIR__."/../services/utils/api.php";

// add
if (isset($_GET['add'])) {
    if (!check_required_fields(['prenom', 'nom', 'email', 'classe', 'motdepasse'])) {
        redirect_with_error(get_full_url("pages/admin/etudiants/etudiants.php"), "Le formulaire est incomplet");
    }

    $numeroEtudiant = $_POST['numeroEtudiant'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $classe = $_POST['classe'];
    $motdepasse = $_POST['motdepasse'];

    $newEtudiant = ajouterEtudiant($numeroEtudiant, $prenom, $nom, $email, $motdepasse, $classe);
    if ($newEtudiant) {
        redirect_with_success($_SERVER['HTTP_REFERER'], "L'étudiant " . $prenom . " " . $nom . " a été ajouté avec succès");
    } else {
        redirect_with_error($_SERVER['HTTP_REFERER'], "Erreur lors de l'ajout de l'étudiant");
    }
}

// edit
if (isset($_GET['edit'])) {
    if (!check_required_fields(['id', 'prenom', 'nom', 'email', 'classe'])) {
        redirect_with_error(get_full_url("pages/admin/etudiants/etudiants.php"), "Le formulaire est incomplet");
    }

    $id = intval($_POST['id']);
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $classe = $_POST['classe'];
    $motdepasse = $_POST['motdepasse'];

    $success = modifierEtudiant($id, $prenom, $nom, $email, $classe, $motdepasse);

    if ($success) {
        redirect_with_success($_SERVER['HTTP_REFERER'], "L'étudiant " . $prenom . " " . $nom . " a été modifié avec succès");
    } else {
        redirect_with_error($_SERVER['HTTP_REFERER'], "Erreur lors de la modification de l'étudiant");
    }
}

// delete
if (isset($_GET['delete'])) {
    $id = intval($_POST['id']);
    $success = supprimerEtudiant($id);

    if ($success) {
        redirect_with_success($_SERVER['HTTP_REFERER'], "L'étudiant a été supprimé avec succès");
    } else {
        redirect_with_error($_SERVER['HTTP_REFERER'], "Erreur lors de la suppression de l'étudiant");
    }
}

// logout
if (isset($_GET['logout'])) {
    logout();
}
