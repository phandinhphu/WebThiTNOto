<?php
if (isset($_SESSION['user'])) {
    header('location: ?module=pages&action=trangchu');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="client/assets/css/login.css">
</head>
<body>
    <div class="form__login">
        <h2>Đăng nhập</h2>
        <div class="input__login">
            <input id="email" type="email" name="email" placeholder="Email..." required>
            <label for="email">Email</label>
        </div>
        <div class="input__login">
            <input id="password" type="password" name="password" placeholder="Mật khẩu..." required>
            <label for="password">Mật khẩu</label>
        </div>
        <a href="?client=pages&action=forgot" class="link__forgot">Quên mật khẩu?</a>
        <div class="btn__submit">
            <button type="button">Đăng nhập</button>
            <a href="?client=pages&action=register" class="link__register">Đăng ký</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const btnSubmit = document.querySelector('.btn__submit button');
        const email = document.getElementById('email');
        const password = document.getElementById('password');

        btnSubmit.addEventListener('click', () => {
            let emailValue = email.value;
            let passwordValue = password.value;
            $.ajax({
                url: 'client/auth/login.php',
                type: 'POST',
                data: {
                    email: emailValue,
                    password: passwordValue
                },
                success: res => {
                    if (res.status === 200) {
                        alert(res.msg);
                        window.location.href = '?module=pages&action=trangchu';
                    } else {
                        alert(res.msg);
                        email.value = '';
                        password.value = '';
                    }
                }
            });
        });
    </script>
</body>
</html>