<?php
require_once '../../db/database.php';

if (isset($_GET['testDate'])) {
    $testDate = $_GET['testDate'];
    $questions = getRows('SELECT history.id AS historyId, history.answerUser, history.result, questions.* 
                        FROM history, questions
                        WHERE history.questionId = questions.id AND dateAnswer = :dateAnswer', ['dateAnswer' => $testDate]);

    header('Content-Type: application/json');
    echo json_encode(['data' => $questions]);
} else {
    http_response_code(400);
}