<?php

require_once 'config.php';
require_once './db/database.php';
require_once './includes/phpmailer/Exception.php';
require_once './includes/phpmailer/PHPMailer.php';
require_once './includes/phpmailer/SMTP.php';
require_once './includes/function.php';
require_once './includes/session.php';

$module = _MODULE;
$action = _ACTION;

if (isset($_GET['module'])) {
    if (is_string($_GET['module'])) {
        $module = trim($_GET['module']);
    }
}

if (isset($_GET['action'])) {
    if (is_string($_GET['action'])) {
        $action = trim($_GET['action']);
    }
}

$path = 'client/' . $module . '/' . $action . '.php';

if (file_exists($path)) {
    require_once $path;
} else {
    require_once 'client/error/404.php';
}