<?php
require_once __DIR__ . "/../includes/services/core/controller.service.php";

// MAIN CONTROLLER

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Handle Request
handle_request($requestMethod, $requestUri);