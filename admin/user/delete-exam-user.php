<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $req = json_decode(file_get_contents('php://input'), true);
    $id = $req['userId'];
    $testDate = $req['testDate'];
    
    $rs = delete('result', ['userId' => $id, 'testDate' => $testDate]);
    $rs2 = delete('history', ['userId' => $id, 'dateAnswer' => $testDate]);

    header('Content-type: application/json');
    if ($rs && $rs2) {
        echo json_encode(['status' => 200,'message' => 'Delete history successfully']);
    } else {
        echo json_encode(['status' => 404,'message' => 'Delete history failed']);
    }
} else {
    http_response_code(404);
}