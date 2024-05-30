<?php

require_once '../../db/database.php';
require_once '../../includes/phpmailer/Exception.php';
require_once '../../includes/phpmailer/PHPMailer.php';
require_once '../../includes/phpmailer/SMTP.php';
require_once '../../includes/function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $res = json_decode(file_get_contents('php://input'), true);
    $id = $res['id'];
    $subject = $res['subject'];
    
    $email = getRow('SELECT email FROM users where id = :id', ['id' => $id])['email'];
    $forgotToken = md5($email).time();
    $content = $res['content'].' <a href="http://localhost/WebThiTN-Oto/client/auth/forgotpassword.php/?token=' . $forgotToken . '">Đổi mật khẩu</a>';

    $rs = sendMail($email, $subject, $content);
    header('Content-Type: application/json');
    if ($rs) {
        update('users', ['forgotToken' => $forgotToken], ['id' => $id]);
        echo json_encode(['status' => 200, 'message' => 'Gửi mail thành công']);
    } else {
        echo json_encode(['status' => 404,'message' => 'Gửi mail thất bại']);
    }
} else {
    http_response_code(404);
}