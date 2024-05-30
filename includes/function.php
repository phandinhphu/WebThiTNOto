<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($to, $subject, $message) {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'phuphandinh2004@gmail.com';                     //SMTP username
        $mail->Password   = 'tebd hrzo dujx nvcr';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('phuphandinh2004@gmail.com', 'Phan Dinh Phu');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getTotalPassAndFail($userId) {
    $sql = 'SELECT users.userName, 
                COUNT(result.userId) AS "Total Test", 
                COALESCE(SUM(CASE WHEN result.ketQua = "Đậu" THEN 1 ELSE 0 END), 0) AS "Total Pass",
                COALESCE(SUM(CASE WHEN result.ketQua = "Rớt" THEN 1 ELSE 0 END), 0) AS "Total Failure"
            FROM users LEFT JOIN result 
            ON users.id = result.userId
            WHERE users.id = ' . $userId . '
            GROUP BY users.userName';
    $res = getRow($sql);
    
    return $res;
}