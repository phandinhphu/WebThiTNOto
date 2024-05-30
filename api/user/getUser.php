<?php

require_once '../../db/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $rs = getRow('SELECT * FROM users WHERE id = :id', ['id' => $id]);

    header('Content-Type: application/json');
    echo json_encode(['data' => $rs]);
} else {
    http_response_code(404);
}