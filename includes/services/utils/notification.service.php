<?php

function generateNotificationScript(): string {
    $pid = random_int(0, 1000);
    $notification_script = <<<HTML
    <script>
        const toastContainer$pid = document.getElementById('toast-container');
        const toast$pid = document.createElement('div');
        toast$pid.id = 'toast-' + Math.random().toString(36).substring(2, 15);
        toast$pid.classList.add('toast');
        toast$pid.role = 'alert';
        toast$pid.innerHTML = /*html*/`
        <div class="toast-header">
            <i class=":iconClass: me-2"></i>
            <strong class=":titleClass: me-auto">:title:</strong>
            <small class="text-body-secondary">maintenant</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            :message:
        </div>
        `
        toastContainer$pid.appendChild(toast$pid);
        const toastBootstrap$pid = bootstrap.Toast.getOrCreateInstance(toast$pid);
        toastBootstrap$pid.show();
    </script>
    HTML;

    return $notification_script;
}

function constructNotification(string $script, array $config): string {
    return str_replace(
        [...array_keys($config)], 
        [...array_values($config)], 
        $script
    );
}

function notify_error(string $title, string $message): void {
    $notification_script = generateNotificationScript();

    // Configuration
    $config = [
        ':iconClass:' => 'bi bi-exclamation-octagon-fill text-danger',
        ':titleClass:' => 'text-danger',
        ':title:' => $title,
        ':message:' => $message
    ];

    // Fusion de la configuration
    $notification_script = constructNotification($notification_script, $config);

    echo $notification_script;
}

function notify_success(string $title, string $message): void {
    $notification_script = generateNotificationScript();

    // Configuration
    $config = [
        ':iconClass:' => 'bi bi-check-circle-fill text-success',
        ':titleClass:' => 'text-success',
        ':title:' => $title,
        ':message:' => $message
    ];

    // Fusion de la configuration
    $notification_script = constructNotification($notification_script, $config);

    echo $notification_script;
}

function notify_info(string $title, string $message): void {
    $notification_script = generateNotificationScript();

    // Configuration
    $config = [
        ':iconClass:' => 'bi bi-info-circle-fill text-info',
        ':titleClass:' => '',
        ':title:' => $title,
        ':message:' => $message
    ];

    // Fusion de la configuration
    $notification_script = constructNotification($notification_script, $config);

    echo $notification_script;
}