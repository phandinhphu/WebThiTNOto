<?php

if (isset($_SESSION['user'])) {
    delete('login', ['userId' => $_SESSION['user']['id']]);
    unset($_SESSION['user']);
    header('Location: ?module=pages&action=trangchu');
    exit();
} else {
    http_response_code(404);
    die();
}