<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $examName = $_POST['examName'];
    $examTime = $_POST['examTime'];
    $examStatus = ($_POST['examStatus'] == 'active') ? 1 : 0;
    
    $dataQuery = [
        'examName' => $examName,
        'timeLimit' => $examTime,
        'createdAt' => date('Y-m-d H:i:s'),
        'updatedAt' => date('Y-m-d H:i:s'),
        'status' => $examStatus
    ];

    $rs = insert('exam', $dataQuery);
    if ($rs) {
        $status = 1;
        $message = 'Add exam successfully';
    } else {
        $status = 0;
        $message = 'Add exam failed';
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