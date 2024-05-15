<?php
session_start();
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsanwser = file_get_contents('php://input');
    $anwser = json_decode($jsanwser, true);
    $timeComplete = $anwser['timeComplete'];

    $score = 0;
    $total = 10;
    $cnt = 0;
    foreach ($anwser['userAnswers'] as $key => $value) {
        $trueAns = getRow('SELECT * FROM questions WHERE id = :id', ['id' => explode('-', $key)[1]]);
        if ($trueAns['answer'] === $value) {
            ++$cnt;
        }
        $dataSql = [
            'userId' => $_SESSION['user']['id'],
            'questionId' => explode('-', $key)[1],
            'answerUser' => $value,
            'result' => $trueAns['answer'] === $value ? 1 : 0,
            'dateAnswer' => date('Y-m-d H:i:s')
        ];
        insert('history', $dataSql);
    }
    
    $score = round(100 * $cnt / $total, 2);

    $dataSql = [
        'userId' => $_SESSION['user']['id'],
        'examName' => $trueAns['chuDe'],
        'score' => $score,
        'timeComplete' => $timeComplete,
        'testDate' => date('Y-m-d H:i:s')
    ];

    insert('result', $dataSql);

    if ($score >= 80) {
        $msg = "Đậu";
    } else {
        $msg = "Rớt";
    }

    $res = [
        'score' => $score,
        'msg' => $msg,
        'timeComplete' => $timeComplete
    ];

    header('Content-Type: application/json');
    echo json_encode($res);
}