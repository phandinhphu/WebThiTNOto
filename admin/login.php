<?php
session_start();
require_once '../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyAdmin = $_POST['keyAdmin'];
    $password = $_POST['password'];
    $err = [];

    $admin = getRow("SELECT * FROM admin WHERE keyAdmin = :keyAdmin", ['keyAdmin' => $keyAdmin]);

    if (!$admin) {
        $err['keyAdmin'] = 'Key không tồn tại';
    }

    if ($admin && !password_verify($password, $admin['password'])) {
        $err['password'] = 'Mật khẩu không đúng';
    }

    if (empty($err)) {
        $_SESSION['admin'] = $admin['keyAdmin'];
        header('Location: http://localhost/WebThiTN-Oto/admin/');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f1f1f1;
        }

        form {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 25%;
            padding: 5px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <label for="keyAdmin">Key</label>
        <input type="text" name="keyAdmin" id="keyAdmin" required>
        <?php if (!empty($err['keyAdmin'])) : ?>
            <p style="color: red; margin-top: 0;"><?= $err['keyAdmin'] ?></p>
        <?php endif; ?>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <?php if (!empty($err['password'])) : ?>
            <p style="color: red; margin-top: 0;"><?= $err['password'] ?></p>
        <?php endif; ?>
        <button type="submit">Login</button>
    </form>
</body>
</html>