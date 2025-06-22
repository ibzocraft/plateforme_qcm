<?php

function echo_success(string $message) {
    echo "\033[32m" . $message . "\033[0m";
}

function echo_danger(string $message) {
    echo "\033[31m" . $message . "\033[0m";
}

function echo_warning(string $message) {
    echo "\033[33m" . $message . "\033[0m";
}

function echo_info(string $message) {
    echo "\033[34m" . $message . "\033[0m";
}

function color_error(string $message) {
    return "\033[31m" . $message . "\033[0m";
}