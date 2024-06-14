<?php
$limit = 15;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$questions = getRows('SELECT history.*, questions.question FROM history, questions
                        WHERE history.questionId = questions.id and userId = :userId
                        ORDER BY dateAnswer DESC LIMIT ' . $start . ', ' . $limit, ['userId' => $_SESSION['user']['id']]);


$total = getRow('SELECT count(*) as total FROM history WHERE userId = :userId', ['userId' => $_SESSION['user']['id']]);
$total_records = $total['total'];
$total_pages = ceil($total_records / $limit);

if (isset($_GET['examName']) && empty($_GET['dateAnswer'])) {
    $total = getRow('SELECT count(*) as total FROM history, questions 
                    WHERE history.questionId = questions.id and userId = :userId and chuDe = :examName', ['userId' => $_SESSION['user']['id'], 'examName' => $_GET['examName']]);
    $total_pages = ceil($total['total'] / $limit);
    $questions = getRows('SELECT history.*, questions.question FROM history, questions
                        WHERE history.questionId = questions.id and userId = :userId and chuDe = :examName
                        ORDER BY dateAnswer DESC LIMIT ' . $start . ', ' . $limit, ['userId' => $_SESSION['user']['id'], 'examName' => $_GET['examName']]);
} elseif (isset($_GET['dateAnswer']) && empty($_GET['examName'])) {
    $questions = getRows('SELECT history.*, questions.question FROM history, questions
                        WHERE history.questionId = questions.id and userId = :userId
                        ORDER BY dateAnswer ' . $_GET['dateAnswer'] . ' LIMIT ' . $start . ', ' . $limit, ['userId' => $_SESSION['user']['id']]);
} elseif (isset($_GET['examName']) && isset($_GET['dateAnswer'])) {
    $total = getRow('SELECT count(*) as total FROM history, questions
                    WHERE history.questionId = questions.id and userId = :userId and chuDe = :examName', ['userId' => $_SESSION['user']['id'], 'examName' => $_GET['examName']]);
    $total_pages = ceil($total['total'] / $limit);
    $questions = getRows('SELECT history.*, questions.question FROM history, questions
                        WHERE history.questionId = questions.id and userId = :userId and chuDe = :examName
                        ORDER BY dateAnswer ' . $_GET['dateAnswer'] . ' LIMIT ' . $start . ', ' . $limit, ['userId' => $_SESSION['user']['id'], 'examName' => $_GET['examName']]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử</title>
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
                                <h3>Lịch sử</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a class="list-group-link" href="?module=pages&action=historyQuestion">Lịch sử câu hỏi</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="list-group-link" href="?module=pages&action=historyExam">Lịch sử bài thi</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3>
                                    Filter
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                                    <input type="hidden" name="module" value="pages">
                                    <input type="hidden" name="action" value="historyQuestion">
                                    <div class="form-group">
                                        <label for="examName">Chọn bài thi</label>
                                        <?php
                                        $exams = getRows('SELECT * FROM exam WHERE status = 1');
                                        foreach ($exams as $exam) : ?>
                                            <div class="form-check ml-5">
                                                <input class="form-check-input" type="radio" name="examName" id="<?php echo $exam['examName']; ?>" value="<?php echo $exam['examName']; ?>" <?php echo isset($_GET['examName']) && $_GET['examName'] == $exam['examName'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label ml-2" for="<?php echo $exam['examName']; ?>">
                                                    <?php echo $exam['examName']; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="dateAnswer">Sắp xếp theo ngày trả lời</label>
                                        <div class="form-check ml-5">
                                            <input class="form-check-input" type="radio" name="dateAnswer" id="asc" value="asc" <?php echo isset($_GET['dateAnswer']) && $_GET['dateAnswer'] == 'asc' ? 'checked' : ''; ?>>
                                            <label class="form-check-label ml-2" for="asc">
                                                Tăng dần
                                            </label>
                                        </div>
                                        <div class="form-check ml-5">
                                            <input class="form-check-input" type="radio" name="dateAnswer" id="desc" value="desc" <?php echo isset($_GET['dateAnswer']) && $_GET['dateAnswer'] == 'desc' ? 'checked' : ''; ?>>
                                            <label class="form-check-label ml-2" for="desc">
                                                Giảm dần
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Lọc</button>
                                    <a class="btn btn-primary mt-3 ml-4" href="?module=pages&action=historyQuestion">Hủy lọc</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col c-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Lịch sử câu hỏi</h3>
                                <div class="alert" role="alert">
                                    <strong></strong>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="form-profile">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Câu hỏi</th>
                                                <th scope="col">Câu trả lời</th>
                                                <th scope="col">Kết quả</th>
                                                <th scope="col">Ngày trả lời</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($questions as $key => $question) : ?>
                                                <tr>
                                                    <th scope="row"><?php echo $key + 1; ?></th>
                                                    <td><?php echo $question['question']; ?></td>
                                                    <td><?php echo $question['answerUser']; ?></td>
                                                    <td><?php echo $question['result'] == 1 ? 'Đúng' : 'Sai'; ?></td>
                                                    <td><?php echo $question['dateAnswer']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col c-3" style="
                        position: fixed;
                        right: 0;
                    ">
                        <div class="card">
                            <div class="card-header">
                                <h3>Phân trang</h3>
                            </div>
                            <div class="card-body">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="flex-wrap: wrap;">
                                        <?php if ($page > 1) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?module=pages&action=historyQuestion<?= isset($_GET['examName']) ? '&examName='.$_GET['examName'] : '' ?><?= isset($_GET['dateAnswer']) ? '&dateAnswer='.$_GET['dateAnswer'] : '' ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>"><a class="page-link" href="?module=pages&action=historyQuestion<?= isset($_GET['examName']) ? '&examName='.$_GET['examName'] : '' ?><?= isset($_GET['dateAnswer']) ? '&dateAnswer='.$_GET['dateAnswer'] : '' ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?module=pages&action=historyQuestion<?= isset($_GET['examName']) ? '&examName='.$_GET['examName'] : '' ?><?= isset($_GET['dateAnswer']) ? '&dateAnswer='.$_GET['dateAnswer'] : '' ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="End">
                                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once 'client/layout/footer.php';
    ?>
</body>

</html>