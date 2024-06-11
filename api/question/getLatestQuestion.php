<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'status' => 405,
        'msg' => 'Method not allowed'
    ]);
    exit;
}
$examName = $_GET['exam_name'];
$testDate = $_GET['test_date'];
$question = getRows('SELECT history.id AS historyId, history.answerUser, history.result, questions.* FROM history, questions
                    WHERE history.questionId = questions.id
                    AND history.dateAnswer = :testDate AND questions.chuDe = :examName',
                    ['testDate' => $testDate, 'examName' => $examName]);

$response = [
    'data' => $question,
];

header('Content-Type: application/json');
echo json_encode($response);