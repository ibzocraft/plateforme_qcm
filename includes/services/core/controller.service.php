<?php

require_once __DIR__."/../utils/path.service.php";

/**
 * @var array $routes
 * 
 * Contient toutes les routes enregistrées.
 * 
 * @example route: [
 *   'method' => string,
 *   'uri' => string,
 *   'handler' => callable
 * ]
 */
$routes = [];
$_routesHashMap = [];
$_currentGroup = "";

function init_controller_group(string $group) {
    global $_currentGroup;
    $_currentGroup = $group;
}

function end_controller_group() {
    global $_currentGroup;
    $_currentGroup = "";
}

function register_controller(string $method, string $uri, callable $handler) {
    global $routes, $_routesHashMap, $_currentGroup;
    $uri = strtr($_currentGroup . $uri, ['//' => '/', '///' => '/']);
    $routes[] = [
        'method' => $method,
        'uri' => $uri,
        'handler' => $handler
    ];
    $_routesHashMap[$method . "|" . $uri] = count($routes) - 1;
    // logger_log("controller registered: " . $method . "|" . $uri);
}

function find_controller(string $method, string $uri) {
    global $_routesHashMap, $routes;

    $routeKey = $method . "|" . $uri;
    if (isset($_routesHashMap[$routeKey])) {
        return $routes[$_routesHashMap[$routeKey]];
    }
    return null;
}

function handle_request(string $method, string $uri) {
    $controller = find_controller($method, $uri);
    if ($controller) {
        // logger_request($method . " > " . $uri);
        $controller['handler']();
    } else {
        http_response_code(404);
        require_once __DIR__ . "/../../../public/404.php";
    }
}

function check_required_fields($fields) {
    foreach ($fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            return false;
        }
    }
    return true;
}


// Register all controllers
foreach (glob(__DIR__ . "/../../controllers/*.php") as $controllerFile) {
    require_once $controllerFile;
    end_controller_group();
}