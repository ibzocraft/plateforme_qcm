<?php
require_once __DIR__ . '/../services/core/functions.php';

if (isset($_GET['toggle'])) {
    $current_theme = $_COOKIE['theme'] ?? 'light';
    $new_theme = $current_theme === 'light' ? 'dark' : 'light';
    change_theme($new_theme);
}
