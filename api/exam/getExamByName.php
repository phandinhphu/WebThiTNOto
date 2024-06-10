<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $examName = $_GET['examName'];
    $exam = getRow("SELECT * FROM exam WHERE examName = :examName", ['examName' => $examName]);
    header('Content-Type: application/json');
    echo json_encode($exam);
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}