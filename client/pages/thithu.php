<?php
if (!isset($_SESSION['user'])) {
    header('location: ?module=pages&action=login');
    exit();
}
if ($_SESSION['user']['status'] == 0) {
    echo '
        <div>
            <h1>Bạn chưa kích hoạt tài khoản</h1>
            <p>Vui lòng kiểm tra email để kích hoạt tài khoản</p>
        </div>
    ';
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thi thử</title>
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

        <div id="fixed-info" style="font-size: 1.6rem; padding: 35px;">
            <h2>Tên bài thi: 
                <?= isset($_GET['exam_name']) ? $_GET['exam_name'] : 'Bài thi trắc nghiệm' ?>
            </h2>
            <p id="time-left">Thời gian còn lại: </p>
            <p id="total-question"></p>
            <div class="quiz__progress">
                <svg>
                    <circle r="50"></circle>
                    <circle id="progress" r="50"></circle>
                </svg>
                <div class="progress__text">
                    <span id="percentage">0.0%</span>
                </div>
            </div>
            <div id="list-id">
                <div class="grid wide">
                    <div class="row"></div>
                </div>
            </div>
        </div>

        <div class="app__container">
            <div class="grid wide container">
                <div class="row">
                    <div class="col l-8 l-o-2">
                        <?php if (isset($_GET['exam_name'])) {
                            $exam = getRow('SELECT * FROM exam WHERE examName = :examName', ['examName' => $_GET['exam_name']]);
                        ?>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Các cuộc thi thử đang mở</div>
                                    <div class="panel-body">
                                        <div class="panel panel-info">
                                            <div class="panel-body">
                                                <?= $exam['examName'] ?>
                                            </div>
                                            <div class="panel-footer">
                                                <div class="mb-2">Thời gian: <?= $exam['timeLimit'] ?> phút</div>
                                                <div class="mb-2">Số câu hỏi: <?= $exam['soCauHoi'] ?> câu</div>
                                                <div class="">
                                                    <button exam-name="<?= $exam['examName'] ?>" class="btn btn-primary btn-start" type="button" align="center">Bắt đầu</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else {
                            $exams = getRows('SELECT * FROM exam WHERE status = 1');
                        ?>
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Các cuộc thi thử đang mở</div>
                                    <?php foreach ($exams as $exam) { ?>
                                        <div class="panel-body">
                                            <div class="panel panel-info">
                                                <div class="panel-body">
                                                    <?= $exam['examName'] ?>
                                                </div>
                                                <div class="panel-footer">
                                                    <div class="mb-2">Thời gian: <?= $exam['timeLimit'] ?> phút</div>
                                                    <div class="mb-2">Số câu hỏi: <?= $exam['soCauHoi'] ?> câu</div>
                                                    <div class="">
                                                        <button exam-name="<?= $exam['examName'] ?>" class="btn btn-primary btn-start" type="button" align="center">Bắt đầu</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        include_once 'client/layout/footer.php';
        ?>
    </div>

    <div class="modal fade" id="modalResult" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="font-size: 1.6rem;">
                <div class="modal-header">
                    <h2>Kết quả thi</h2>
                </div>
                <div class="modal-body">
                    <p>Điểm của bạn: <span id="score"></span></p>
                    <p id="msg"></p>
                    <div id="time-comple"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-view-result">Xem đáp án</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalViewResult" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="font-size: 1.6rem;">
                <div class="modal-header">
                    <h2>Đáp án</h2>
                </div>
                <div class="modal-body" style="
                    overflow: scroll;
                    height: 400px;
                    overflow-y: scroll;
                    overflow-x: hidden;
                ">
                    <div id="list-answer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="./client/assets/js/generateQuestion.js"></script>
</body>

</html>