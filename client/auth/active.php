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
            if (isset($_SESSION['user'])) {
                delete('login', ['userId' => $_SESSION['user']['id']]);
                session_destroy();
            }
            echo 'Kích hoạt tài khoản thành công </br>';
            echo '
                <a href="'.BASE_URL.'?module=pages&action=login">Đăng nhập</a>
            ';
            exit();
        } catch (Exception $e) {
            echo 'Đã xảy ra lỗi';
        }
    } else {
        echo 'Token không hợp lệ hoặc đã hết hạn';
    }
}