<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL.'client/assets/css/login.css' ?>">
</head>

<body>
    <div class="form__login">
        <div class="content__first">
            <h2>Đăng ký</h2>
            <div id="loading" style="display:none;">Please wait...</div>
            <div id="alert"></div>
            <div class="input__login">
                <input id="name" type="text" name="name" placeholder="Họ và tên..." required>
                <label for="name">Họ và tên</label>
            </div>
            <div class="alert-name"></div>
            <div class="input__login">
                <input id="email" type="text" name="email" placeholder="Email..." required>
                <label for="email">Email</label>
            </div>
            <div class="alert-email"></div>
            <div class="input__login">
                <input id="password" type="password" name="password" placeholder="Mật khẩu..." required>
                <label for="password">Mật khẩu</label>
            </div>
            <div class="alert-password"></div>
            <div class="input__login">
                <input id="confirmPassword" type="password" name="confirmPassword" placeholder="Nhập lại mật khẩu..." required>
                <label for="confirmPassword">Nhập lại mật khẩu</label>
            </div>
            <div class="alert-confirm-password"></div>
            <div class="input__login">
                <input id="phone" type="text" name="phone" placeholder="Số điện thoại..." required>
                <label for="phone">Số điện thoại</label>
            </div>
            <div class="alert-phone"></div>
            <div class="btn__submit">
                <button id="registerButton" type="button" class="btn">Đăng ký</button>
                <a href="?module=pages&action=login" class="btn link__register">Đăng nhập</a>
            </div>
        </div>
        <div class="content__second">
            <p class="content">
                <span>Chào mừng bạn đến với trang web thi thử trắc nghiệm ô tô của chúng tôi.</span>
                <br/>
                <span>Đăng ký để sử dụng dịch vụ của chúng tôi</span>
            </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const btnSubmit = document.querySelector('.btn__submit button');
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const phone = document.getElementById('phone');

        btnSubmit.addEventListener('click', () => {
            $('#alert').html('');
            $('.alert-name').html('');
            $('.alert-email').html('');
            $('.alert-password').html('');
            $('.alert-confirm-password').html('');
            $('.alert-phone').html('');

            let nameValue = name.value;
            let emailValue = email.value;
            let passwordValue = password.value;
            let confirmPasswordValue = confirmPassword.value;
            let phoneValue = phone.value;

            if (nameValue === '') {
                $('.alert-name').html(`<p class="text-danger">Vui lòng nhập họ và tên!!!</p>`);
                return;
            }

            if (emailValue === '') {
                $('.alert-email').html(`<p class="text-danger">Vui lòng nhập email!!!</p>`);
                return;
            }

            if (passwordValue === '') {
                $('.alert-password').html(`<p class="text-danger">Vui lòng nhập mật khẩu!!!</p>`);
                return;
            }

            if (confirmPasswordValue === '') {
                $('.alert-confirm-password').html(`<p class="text-danger">Vui lòng nhập lại mật khẩu!!!</p>`);
                return;
            }

            if (phoneValue === '') {
                $('.alert-phone').html(`<p class="text-danger">Vui lòng nhập số điện thoại!!!</p>`);
                return;
            }

            if (passwordValue.length < 6) {
                $('.alert-password').html(`<p class="text-danger">Mật khẩu phải lớn hơn 6 ký tự!!!</p>`);
                return;
            }

            if (passwordValue !== confirmPasswordValue) {
                $('.alert-confirm-password').html(`<p class="text-danger">Mật khẩu không khớp!!!</p>`);
                return;
            }

            let regex = /^(0)[0-9]{9}$/;
            if (!regex.test(phoneValue)) {
                $('.alert-phone').html(`<p class="text-danger">Số điện thoại không hợp lệ!!!</p>`);
                return;
            }
            
            $('#loading').show();
            $('#registerButton').addClass('btn--disabled');
            $('.link__register').addClass('disabled');

            $.ajax({
                url: 'client/auth/register.php',
                type: 'POST',
                data: {
                    name: nameValue,
                    email: emailValue,
                    password: passwordValue,
                    phone: phoneValue
                },
                success: res => {
                    if (res.status === 200) {
                        $('#loading').hide();
                        $('#registerButton').removeClass('btn--disabled');
                        $('.link__register').removeClass('disabled');

                        $('#alert').html(`<div class="alert alert-success" role="alert">${res.msg}!!!</div>`);
                    } else {
                        $('#loading').hide();
                        $('#registerButton').removeClass('btn--disabled');
                        $('.link__register').removeClass('disabled');

                        $('#alert').html(`<div class="alert alert-danger" role="alert">${res.msg}!!!</div>`);
                        name.value = '';
                        email.value = '';
                        password.value = '';
                        confirmPassword.value = '';
                        phone.value = '';
                    }
                }
            });
        });
    </script>
</body>

</html>