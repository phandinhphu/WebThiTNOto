<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'status' => 405,
        'msg' => 'Method not allowed'
    ]);
    exit;
}
$total = $_GET['totalQuestion'];
$question = getRows('SELECT history.id AS historyId, history.answerUser, history.result, questions.* FROM history, questions
                    WHERE history.questionId = questions.id
                    ORDER BY history.id DESC
                    LIMIT ' . $total);

$response = [
    'data' => $question,
];

header('Content-Type: application/json');
echo json_encode($response);