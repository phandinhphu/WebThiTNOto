<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $examName = $_POST['examName'];
    $where = ['examName' => $examName];
    $rs = delete('exam', $where);
    if ($rs) {
        $status = 1;
        $message = 'Delete exam successfully';
    } else {
        $status = 0;
        $message = 'Delete exam failed';
    }
    $res = [
        'status' => $status,
        'message' => $message
    ];
    header('Content-Type: application/json');
    echo json_encode($res);
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}