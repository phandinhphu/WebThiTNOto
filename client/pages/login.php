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
        <div class="content__first">
            <h2>Đăng nhập</h2>
            <div class="alert"></div>
            <div class="input__login">
                <input id="email" type="email" name="email" placeholder="Email..." required>
                <label for="email">Email</label>
            </div>
            <div class="alert-email"></div>
            <div class="input__login">
                <input id="password" type="password" name="password" placeholder="Mật khẩu..." required>
                <label for="password">Mật khẩu</label>
            </div>
            <div class="alert-password"></div>
            <div class="link__forgot"></div>
            <div class="btn__submit">
                <button type="button" class="btn">Đăng nhập</button>
                <a href="?client=pages&action=forgot" class="btn link__register">Quên mật khẩu?</a>
            </div>
        </div>
        <div class="content__second">
            <p class="content">
                <span>Chào mừng bạn đến với trang web thi thử trắc nghiệm ô tô của chúng tôi.</span>
                <br/>
                <span>Đăng nhập để sử dụng dịch vụ của chúng tôi.</span>
                <br/>
                <span>
                    Bạn chưa có tài khoản?
                    <a href="?client=pages&action=register" class="btn link__register">Đăng ký</a>
                </span>
            </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const btnSubmit = document.querySelector('.btn__submit button');
        const email = document.getElementById('email');
        const password = document.getElementById('password');

        btnSubmit.addEventListener('click', () => {
            $('.alert').html('');
            $('.alert-email').html('');
            $('.alert-password').html('');

            let emailValue = email.value;
            let passwordValue = password.value;

            if (emailValue === '') {
                $('.alert-email').html(`<p class="text-danger">Vui lòng nhập email!!!</p>`);
                return;
            }

            if (passwordValue === '') {
                $('.alert-password').html(`<p class="text-danger">Vui lòng nhập mật khẩu!!!</p>`);
                return;
            }

            let regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            if (!regexEmail.test(emailValue)) {
                $('.alert-email').html(`<p class="text-danger">Email không hợp lệ!!!</p>`);
                return;
            }

            if (passwordValue.length < 6) {
                $('.alert-password').html(`<p class="text-danger">Mật khẩu phải lớn hơn 6 ký tự!!!</p>`);
                return;
            }

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
                        $('.alert').html(`<div class="alert alert-danger" role="alert">${res.msg}!!!</div>`);
                        email.value = '';
                        password.value = '';
                    }
                }
            });
        });
    </script>
</body>
</html>