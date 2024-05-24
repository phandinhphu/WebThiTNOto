<?php
session_start();
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsanwser = file_get_contents('php://input');
    $anwser = json_decode($jsanwser, true);
    $timeComplete = $anwser['timeComplete'];

    $score = 0;
    $total = $anwser['totalQuestion'];
    $cntTrue = 0;
    $cntFalse = 0;
    $dataAnwser = date('Y-m-d H:i:s');
    foreach ($anwser['userAnswers'] as $key => $value) {
        $trueAns = getRow('SELECT * FROM questions WHERE id = :id', ['id' => explode('-', $key)[1]]);
        if ($trueAns['answer'] === $value) {
            ++$cntTrue;
        } else {
            ++$cntFalse;
        }
        $dataSql = [
            'userId' => $_SESSION['user']['id'],
            'questionId' => explode('-', $key)[1],
            'answerUser' => $value,
            'result' => $trueAns['answer'] === $value ? 1 : 0,
            'dateAnswer' => $dataAnwser
        ];
        insert('history', $dataSql);
    }
    
    $cntTrong = 0;
    if ($cntTrue + $cntFalse < $total) {
        $cntTrong = $total - $cntTrue - $cntFalse;
    }

    $score = round(100 * $cntTrue / $total, 2);

    $dataSql = [
        'userId' => $_SESSION['user']['id'],
        'examName' => $trueAns['chuDe'],
        'score' => $score,
        'timeComplete' => $timeComplete,
        'testDate' => date('Y-m-d H:i:s'),
        'soCauDung' => $cntTrue,
        'soCauSai' => $cntFalse,
        'soCauTrong' => $cntTrong,
        'ketQua' => $score >= 80 ? 'Đậu' : 'Rớt'
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