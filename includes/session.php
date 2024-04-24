<?php

function setData($data) {
    $_SESSION['data'] = $data;
}

function getData() {
    return $_SESSION['data'];
}

function setFlashData($key, $data) {
    $flashKey = 'flash_' . $key;
    $_SESSION[$flashKey] = $data;
}

function getFlashData($key) {
    $flashKey = 'flash_' . $key;
    $data = $_SESSION[$flashKey];
    unset($_SESSION[$flashKey]);
    return $data;
}