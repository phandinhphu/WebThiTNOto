<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $question = getRow("SELECT * FROM questions WHERE id = :id", ['id' => $id]);
    header('Content-Type: application/json');
    echo json_encode($question);
} else {
    header("HTTP/1.0 405 Method Not Allowed");
}