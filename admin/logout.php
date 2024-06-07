<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: http://localhost/WebThiTN-Oto/admin/login.php');
} else {
    unset($_SESSION['admin']);
    header('Location: http://localhost/WebThiTN-Oto/admin/login.php');
}