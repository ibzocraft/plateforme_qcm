<?php

function redirect($url, $status_code = 301) {
    header("Location: $url", true, $status_code);
    exit();
}

function redirect_with_success($url, $success, $status_code = 301) {
    $success = urlencode($success);
    header("Location: $url?success=$success", true, $status_code);
    exit();
}
function redirect_with_error($url, $error, $status_code = 301) {
    $error = urlencode($error);
    header("Location: $url?error=$error", true, $status_code);
    exit();
}

function change_theme(string $theme): void {
    setcookie("theme", $theme, time() + 3600 * 24 * 30, "/");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

/**
 * Génère les paramètres pour une requête de mise à jour, evite la repetion dans les updates
 * @param int $id ID de l'utilisateur
 * @param array $allowedFields Champs autorisés pour la mise à jour
 * @param array $data Données à mettre à jour
 * @return array|false Tableau contenant les mises à jour et paramètres, ou false si aucune mise à jour valide
 */
function generateParamsForUpdateQuery($id, $allowedFields, $data): array|false {
    $updates = [];
    $params = [':id' => $id];

    foreach ($data as $key => $value) {
        if (in_array($key, $allowedFields)) {
            $updates[] = "$key = :$key";
            $params[":$key"] = $value;
        }
    }

    if (empty($updates)) return false;
    return ['updates' => $updates, 'params' => $params];
}