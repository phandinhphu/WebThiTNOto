<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $questionTopic = $_POST['questionTopic'];
    $answerA = $_POST['answerA'];
    $answerB = $_POST['answerB'];
    $answerC = $_POST['answerC'];
    $answerD = $_POST['answerD'];
    $correctAnswer = $_POST['answerCorrect'];
    $difficulty = $_POST['questionDiff'];

    $data = [
        'question' => $question,
        'chuDe' => $questionTopic,
        'optionA' => $answerA,
        'optionB' => $answerB,
        'optionC' => $answerC,
        'optionD' => $answerD,
        'answer' => $correctAnswer,
        'difficulty' => $difficulty,
    ];

    $where = [
        'id' => $id
    ];
    
    $rs = update('questions', $data, $where);
    if ($rs) {
        $status = 1;
        $message = 'Cập nhật câu hỏi thành công';
    } else {
        $status = 0;
        $message = 'Cập nhật câu hỏi thất bại';
    }
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
} else {
    header("HTTP/1.0 405 Method Not Allowed");
}