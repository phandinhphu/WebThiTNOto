<?php
if (!isset($_SESSION['user'])) {
    header('location: ?module=pages&action=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <div class="c-12">
                        <div class="app__content">
                            <h1 class="app__content-heading">Chào mừng bạn đến với hệ thống thi lái xe ô tô</h1>
                            <p class="app__content-description">Hệ thống thi lái xe ô tô giúp bạn ôn tập và thi thử để chuẩn bị cho kỳ thi sát hạch lái xe ô tô sắp tới.</p>
                            <p class="app__content-description">Hãy chọn một trong các chức năng ở menu để bắt đầu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            include_once 'client/layout/footer.php';
        ?>
    </div>
</body>
</html>