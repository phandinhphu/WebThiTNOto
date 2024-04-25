<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questionName = $_POST['question'];
    $questionTopic = $_POST['questionTopic'];
    $answerA = $_POST['answerA'];
    $answerB = $_POST['answerB'];
    $answerC = $_POST['answerC'];
    $answerD = $_POST['answerD'];
    $correctAnswer = $_POST['answerCorrect'];
    $questionDifficulty = $_POST['questionDiff'];

    $data = [
        'chuDe' => $questionTopic,
        'question' => $questionName,
        'optionA' => $answerA,
        'optionB' => $answerB,
        'optionC' => $answerC,
        'optionD' => $answerD,
        'answer' => $correctAnswer,
        'difficulty' => $questionDifficulty
    ];

    $rs = insert('questions', $data);
    
    if ($rs) {
        $status = 1;
        $message = 'Thêm câu hỏi thành công';
    } else {
        $status = 0;
        $message = 'Thêm câu hỏi thất bại';
    }
    $res = [
        'status' => $status,
        'message' => $message
    ];
    header('Content-Type: application/json');
    echo json_encode($res);
} else {
    header('Content-type: application/json');
    echo json_encode(['status' => 0, 'message' => 'Method not allowed']);
}