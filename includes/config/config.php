<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Chargement des variables d'environnement depuis .env vers $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
