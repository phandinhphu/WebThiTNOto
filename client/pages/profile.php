<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL.'client/assets/css/grid.css' ?>">
    <link rel="stylesheet" href="<?= BASE_URL.'client/assets/css/main.css' ?>">
    <script src="<?= BASE_URL.'client/assets/js/logout.js' ?>"></script>
</head>

<body>
    <div class="app">
        <?php
        include_once 'client/layout/header.php';
        ?>

        <div class="app__container">
            <div class="grid wide">
                <div class="row">
                    <div class="col c-3">
                        <div class="card">
                            <div class="card-header">
                                <h3>Tài khoản của tôi</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a class="list-group-link" href="?module=pages&action=profile&layout=hosoUser">Hồ sơ</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="list-group-link" href="?module=pages&action=profile&layout=resetpassword">Đổi mật khẩu</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_GET['layout'])) {
                        $layout = $_GET['layout'];
                    } else {
                        $layout = 'hosoUser';
                    }
                    include_once './client/pages/' . $layout . '.php';
                    ?>
                </div>
            </div>
        </div>
        
        <?php
        include_once 'client/layout/footer.php';
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="./client/assets/js/resetpassword.js"></script>
    <script src="./client/assets/js/changeinfo.js"></script>
</body>

</html>