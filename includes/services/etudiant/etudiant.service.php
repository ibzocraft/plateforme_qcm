<?php
require_once __DIR__ . '/../../database/crud/utilisateur.php';
require_once __DIR__ . '/../../services/core/functions.php';

function get_etudiants() {
    $etudiants = recupererUtilisateursParRole('etudiant');
    return $etudiants;
}

function get_etudiant_by_id($id) {
    $id = intval($id);
    $etudiant = recupererUtilisateurParId($id);
    return $etudiant;
}

function ajouterEtudiant($numeroEtudiant, $prenom, $nom, $email, $motdepasse, $classe) {
    if (empty($numeroEtudiant)) {
        $numeroEtudiant = generate_etudiant_number();
    }

    $etudiant = ajouterUtilisateur(
        $numeroEtudiant, 
        $prenom, 
        $nom, 
        $email, 
        $motdepasse, 
        $classe, 
        'etudiant'
    );
    return $etudiant;
}
function modifierEtudiant($id, $prenom, $nom, $email, $classe, $motdepasse) {
    $result = modifierUtilisateur($id, [
        'prenom' => $prenom,
        'nom' => $nom,
        'email' => $email,
        'classe' => $classe,
        'mot_de_passe' => $motdepasse
    ]);
    return $result;
}

function generate_etudiant_number() {
    $nEtudiants = count(recupererUtilisateursParRole('etudiant'));
    $nEtudiants++;
    return 'ETU' . str_pad($nEtudiants, 3, '0', STR_PAD_LEFT);
}
