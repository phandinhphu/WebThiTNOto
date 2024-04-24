<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $examName = $_POST['examName'];
    $examTime = $_POST['examTime'];
    $examStatus = ($_POST['examStatus'] == 'active') ? 1 : 0;
    
    $dataQuery = [
        'examName' => $examName,
        'timeLimit' => $examTime,
        'updatedAt' => date('Y-m-d H:i:s'),
        'status' => $examStatus
    ];
    $where = ['examName' => $examName];
    $rs = update('exam', $dataQuery, $where);

    if ($rs) {
        $status = 1;
        $message = 'Edit exam successfully';
    } else {
        $status = 0;
        $message = 'Edit exam failed';
    }

    $res = [
        'status' => $status,
        'message' => $message
    ];

    header('Content-type: application/json');
    echo json_encode($res);
} else {
    header('Content-type: application/json');
    echo json_encode(['status' => 0, 'message' => 'Method not allowed']);
}