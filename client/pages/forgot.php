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
        <h2>Quên mật khẩu</h2>
        <div class="alert"></div>
        <div class="input__login">
            <input id="email" type="email" name="email" placeholder="Email..." required>
            <label for="email">Email</label>
        </div>
        <div class="btn__submit">
            <button type="submit">Gửi email</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const btnSubmit = document.querySelector('.btn__submit button');

        btnSubmit.addEventListener('click', (e) => {
            let email = document.getElementById('email').value;

            $.ajax({
                url: 'http://localhost/WebThiTN-Oto/client/auth/forgotpassword.php',
                type: 'POST',
                data: {
                    email: email
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