<?php

require_once '../../db/database.php';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $questions = getRows("SELECT * FROM questions LIMIT $limit OFFSET $offset");
    header('Content-Type: application/json');
    echo json_encode($questions);
} else {
    $questions = getRows('SELECT * FROM questions');
    header('Content-Type: application/json');
    echo json_encode($questions);
}