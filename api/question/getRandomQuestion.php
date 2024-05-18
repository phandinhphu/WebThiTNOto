<?php

require_once '../../db/database.php';

if (isset($_GET['exam_name'])) {
    $examName = $_GET['exam_name'];
    $question = getRows('SELECT * FROM questions WHERE chuDe = :chuDe ORDER BY RAND() LIMIT 40', ['chuDe' => $examName]);
    $timeLimit = getRow('SELECT * FROM exam WHERE examName = :examName', ['examName' => $examName])['timeLimit'];
    
    if ($question) {
        $status = 200;
        $message = 'Lấy câu hỏi thành công';
    } else {
        $status = 404;
        $message = 'Không tìm thấy câu hỏi';
    }

    header('Content-type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $question,
        'timeLimit' => $timeLimit,
        'totalQuestion' => count($question)
    ]);
} else {
    http_response_code(404);
    include_once '../../client/error/404.php';
}