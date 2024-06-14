<?php

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://'.$_SERVER['HTTP_HOST'];
} else {
    $uri = 'http://'.$_SERVER['HTTP_HOST'];
}

$foder = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$uri .= $foder;

define('BASE_URL', $uri);

const _MODULE = 'pages';
const _ACTION = 'trangchu';