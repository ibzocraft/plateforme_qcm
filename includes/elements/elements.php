<?php
require_once __DIR__ . '/../services/utils/path.php';

function _element_var_replacer(string $html, array $vars) {
    foreach ($vars as $key => $value) {
        $html = str_replace("{{{$key}}}", $value, $html);
    } return $html;
}

// Include all elements
require_once __DIR__ . '/module-header.php';
require_once __DIR__ . '/crud-module-header.php';
// Can't include time i didn't put it in a function