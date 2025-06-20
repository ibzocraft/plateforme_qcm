<?php
require_once __DIR__ . '/elements.php';

function crud_module_header(string $title, string $description, string $button_text, string $button_target, ?string $previous_page = null): void {
    $html = <<<HTML
        <!-- Page Header -->
        <div class="row p-4 justify-content-between rounded-4 bg-theme mx-1 mb-3 spawn-fade-in">
            <div class="col-8">
                <p class="text-custom-dark fs-2 fw-bold mb-2">{{title}}</p>
                <p class="text-muted">{{description}}</p>
            </div>
            <div class="col-4">
                <div class="d-flex h-100 justify-content-end align-items-center gap-2">
                    <a class="btn btn-dark fw-medium text-decoration-none" href="{{previous_page}}">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="{{button_target}}">
                        {{button_text}} <i class="bi bi-plus-lg"></i> 
                    </button>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
    HTML;

    echo _element_var_replacer($html, [
        'title' => $title,
        'description' => $description,
        'button_text' => $button_text,
        'button_target' => $button_target,
        'previous_page' => $previous_page ?? get_previous_page()
    ]);
}

