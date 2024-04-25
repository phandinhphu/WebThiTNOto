<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $examName = $_POST['examName'];
    $questions = getRows("SELECT * FROM questions WHERE exam_name = :examName", ['examName' => $examName]);
    header('Content-Type: application/json');
    echo json_encode($questions);
} else {
    header("HTTP/1.0 405 Method Not Allowed");
}