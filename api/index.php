<?php

if (isset($_GET['debug'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? null,
        'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? null,
        'VERCEL'      => getenv('VERCEL'),
    ]);
    exit;
}

require __DIR__ . '/../public/index.php';