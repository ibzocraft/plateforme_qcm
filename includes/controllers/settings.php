<?php
require_once __DIR__.'/../services/core/functions.service.php';
require_once __DIR__.'/../services/core/controller.service.php';

init_controller_group("/settings");

register_controller("GET", "/toggle-theme", function() {
    $current_theme = $_COOKIE['theme'] ?? 'light';
    $new_theme = $current_theme === 'light' ? 'dark' : 'light';
    change_theme($new_theme);
});
