<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $req = json_decode(file_get_contents('php://input'), true);
    $id = $req['userId'];
    $testDate = $req['testDate'];
    $soCauDung = $req['soCauDung'];
    $soCauSai = $req['soCauSai'];
    $score = $req['score'];

    $data = [
       'soCauDung' => $soCauDung,
       'soCauSai' => $soCauSai,
       'score' => $score,
       'ketQua' => $score >= 80 ? 'Đậu' : 'Rớt'
    ];

    $where = [
        'userId' => $id,
        'testDate' => $testDate
    ];

    $rs = update('result', $data, $where);

    header('Content-type: application/json');
    if ($rs) {
        echo json_encode(['status' => 200,'message' => 'Update history successfully']);
    } else {
        echo json_encode(['status' => 404,'message' => 'Update history failed']);
    }
} else {
    http_response_code(404);
}