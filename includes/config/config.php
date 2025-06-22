<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Chargement des variables d'environnement depuis .env vers $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_NAME'] = 'fila9119_questions ';
$_ENV['DB_USER'] = 'fila9119_ibzocraft';
$_ENV['DB_PASSWORD'] = 'eFU(uZ]G2S3l';

$_ENV['BASE_URL'] = 'https://questions.arsonry.com/';