<?php

if (empty($_GET['token'])) {
    echo 'Không tìm thấy Token kích hoạt';
} else {
    $activeTokenRQ = $_GET['token'];
    $activeTokenDB = getRow('SELECT * FROM users WHERE activeToken = :activeToken', ['activeToken' => $activeTokenRQ]);
    
    if ($activeTokenDB) {
        $data = [
            'activeToken' => '',
            'status' => 1
        ];
        try {
            $result = update('users', $data, ['id' => $activeTokenDB['id']]);
            header('Location: http://localhost/WebThiTN-Oto/?module=pages&action=login');
            exit();
        } catch (Exception $e) {
            echo 'Đã xảy ra lỗi';
        }
    } else {
        echo 'Token không hợp lệ hoặc đã hết hạn';
    }
}