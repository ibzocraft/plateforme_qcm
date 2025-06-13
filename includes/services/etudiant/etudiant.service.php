<?php
require_once __DIR__ . '/../../database/crud/utilisateur.php';
require_once __DIR__ . '/../../services/core/functions.php';

function get_etudiants() {
    $etudiants = recupererUtilisateursParRole('etudiant');
    return $etudiants;
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

function generate_etudiant_number() {
    $nEtudiants = count(recupererUtilisateursParRole('etudiant'));
    $nEtudiants++;
    return 'ETU' . str_pad($nEtudiants, 3, '0', STR_PAD_LEFT);
}