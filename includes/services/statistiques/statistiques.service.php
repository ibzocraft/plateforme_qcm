<?php

require_once __DIR__ . '/../../database/crud/utilisateur.php';
require_once __DIR__ . '/../../database/crud/reponse.php';
require_once __DIR__ . '/../../database/crud/note.php';
require_once __DIR__ . '/../../database/crud/resultat.php';
require_once __DIR__ . '/../../database/crud/question.php';
require_once __DIR__ . '/../../database/crud/qcm.php';


function getLastQCMResults() {
    return recupererDerniersResultats();
}