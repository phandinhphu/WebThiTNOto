<?php

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    header('Location: ?module=pages&action=trangchu');
    exit();
} else {
    http_response_code(404);
    die();
}