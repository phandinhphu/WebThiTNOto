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
            <div id="loading" style="display:none;">Please wait...</div>
            <div class="alert"></div>
            <div class="input__login">
                <input id="email" type="email" name="email" placeholder="Email..." required>
                <label for="email">Email</label>
            </div>
            <div class="btn__submit">
                <button id="forgot-btn" class="btn" type="submit">Gửi email</button>
                <a href="?client=pages&action=login" class="btn link__register">Đăng nhập</a>
            </div>
        </div>
        <div class="content__second">
            <p class="content">
                <span>Chào mừng bạn đến với trang web thi thử trắc nghiệm ô tô của chúng tôi.</span>
                <br/>
                <span>Nhập email của bạn để lấy lại mật khẩu.</span>
            </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const btnSubmit = document.querySelector('.btn__submit button');

        btnSubmit.addEventListener('click', (e) => {
            let email = document.getElementById('email').value;

            $('.alert').html('');

            let regex = /[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}/igm;
            if (!regex.test(email)) {
                $('.alert').html(`<div class="alert alert-danger" role="alert">Email không hợp lệ</div>`);
                return;
            }

            $('#loading').show();
            $('#forgot-btn').addClass('btn--disabled');
            $('.link__register').addClass('disabled');

            $.ajax({
                url: 'http://localhost/WebThiTN-Oto/client/auth/forgotpassword.php',
                type: 'POST',
                data: {
                    email: email
                },
                success: (res) => {
                    if (res.status == 200) {
                        let html = `
                            <span>Chào mừng bạn đến với trang web thi thử trắc nghiệm ô tô của chúng tôi.</span>
                            <br/>
                            <span>Vui lòng kiểm tra email để đổi mật khẩu.</span>
                        `;

                        $('.content').html(html);
                        $('.alert').html(`<div class="alert alert-success" role="alert">${res.msg}</div>`);
                        $('#loading').hide();
                        $('#forgot-btn').removeClass('btn--disabled');
                        $('.link__register').removeClass('disabled');
                    } else {
                        let html = `
                            <span>Chào mừng bạn đến với trang web thi thử trắc nghiệm ô tô của chúng tôi.</span>
                            <br/>
                            <span>Nhập email của bạn để lấy lại mật khẩu.</span>
                        `;

                        $('.content').html(html);
                        $('.alert').html(`<div class="alert alert-danger" role="alert">${res.msg}</div>`);
                        $('#loading').hide();
                        $('#forgot-btn').removeClass('btn--disabled');
                        $('.link__register').removeClass('disabled');
                    }
                }
            });
        });
    </script>
</body>
</html>