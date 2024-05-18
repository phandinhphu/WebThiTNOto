<?php

require_once '../../db/database.php';

$question = getRows('SELECT history.id AS historyId, history.answerUser, history.result, questions.* FROM history, questions
                    WHERE history.questionId = questions.id
                    ORDER BY history.id DESC
                    LIMIT 40');

$response = [
    'data' => $question,
];

header('Content-Type: application/json');
echo json_encode($response);