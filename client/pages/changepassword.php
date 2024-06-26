<?php
if (!isset($_SESSION['id'])) {
    http_response_code(403);
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="client/assets/css/login.css">
</head>

<body>
    <div class="form__login">
        <div class="content__first">
            <h2>Quên mật khẩu</h2>
            <div class="alert"></div>
            <div class="input__login">
                <input id="password" type="password" name="password" placeholder="Mật khẩu..." required>
                <label for="password">Mật khẩu</label>
            </div>
            <div class="alert-password"></div>
            <div class="input__login">
                <input id="repassword" type="password" name="repassword" placeholder="Nhập lại mật khẩu..." required>
                <label for="repassword">Nhập lại mật khẩu</label>
            </div>
            <div class="alert-repassword"></div>
            <div class="btn__submit">
                <button type="submit" class="btn">Đổi mật khẩu</button>
                <a href="?client=pages&action=login" class="btn link__register">Đăng nhập</a>
            </div>
        </div>
        <div class="content__second">
            <p class="content">
                <span>Chào mừng bạn đến với trang web thi thử trắc nghiệm ô tô của chúng tôi.</span>
                <br />
                <span>Nhập mật khẩu mới của bạn.</span>
                <br />
                <span>Trong quá trình đổi mật khẩu vui lòng không refresh trang.</span>
            </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const btnSubmit = document.querySelector('.btn__submit button');

        btnSubmit.addEventListener('click', (e) => {
            $('.alert').html('');
            $('.alert-password').html('');
            $('.alert-repassword').html('');

            let password = document.getElementById('password').value;
            let repassword = document.getElementById('repassword').value;

            if (password.length < 6) {
                $('.alert-password').html(`<p class="text-danger">Mật khẩu phải lớn hơn 6 ký tự</p>`);
                return;
            }

            if (password != repassword) {
                $('.alert-repassword').html(`<p class="text-danger">Mật khẩu không khớp</p>`);
                return;
            }

            $.ajax({
                url: 'http://localhost/WebThiTN-Oto/client/auth/changepassword.php',
                type: 'POST',
                data: {
                    password: password
                },
                success: (res) => {
                    if (res.status == 200) {
                        $('.alert').html(`<div class="alert alert-success" role="alert">${res.msg}</div>`);
                    } else {
                        $('.alert').html(`<div class="alert alert-danger" role="alert">${res.msg}</div>`);
                    }
                }
            });
        });
    </script>
</body>

</html>