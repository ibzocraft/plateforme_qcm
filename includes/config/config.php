<?php
// require_once __DIR__ . '/../../vendor/autoload.php';

// // Chargement des variables d'environnement depuis .env vers $_ENV
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
// $dotenv->load();

$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_NAME'] = 'plateforme_qcm';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASSWORD'] = '';
$_ENV['DB_NAME'] = 'plateforme_qcm';

$_ENV['BASE_URL'] = 'http://localhost/plateforme_qcm/';