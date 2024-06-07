<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    
    $examUser = getRows('SELECT exam.soCauHoi, result.*
                        FROM result, exam
                        WHERE result.examName = exam.examName
                        AND result.userId = :userId', ['userId' => $id]);

    header('Content-type: application/json');
    if ($examUser) {
        echo json_encode(['status' => 200, 'data' => $examUser]);
    } else {
        $examUser = [];
        echo json_encode(['status' => 404, 'data' => $examUser, 'message' => 'Not found data']);
    }
} else {
    http_response_code(404);
}