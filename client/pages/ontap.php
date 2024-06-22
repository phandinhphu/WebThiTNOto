<?php
if (!isset($_SESSION['user'])) {
    header('location: ?module=pages&action=login');
    exit();
}


if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$limit = 15;

$start = ($page - 1) * $limit;

$total = getRows("SELECT * FROM questions");
$totalPage = ceil(count($total) / $limit);
$questions = getRows("SELECT * FROM questions LIMIT $start, $limit");

if (isset($_GET['examName']) && empty($_GET['_sort'])) {
    $examName = $_GET['examName'];
    $total = getRows('SELECT * FROM questions WHERE chuDe = :chuDe', ["chuDe" => $examName]);
    $totalPage = ceil(count($total) / $limit);
    $questions = getRows("SELECT * FROM questions WHERE chuDe = :chuDe LIMIT $start, $limit", ["chuDe" => $examName]);
}

if (isset($_GET['_sort']) && empty($_GET['examName'])) {
    $sort = $_GET['_sort'];
    $totalPage = ceil(count(getRows('SELECT * FROM questions WHERE difficulty = :difficulty', ["difficulty" => $sort])) / $limit);
    $questions = getRows("SELECT * FROM questions WHERE difficulty = :difficulty LIMIT $start, $limit", ["difficulty" => $sort]);
}

if (isset($_GET['_sort']) && isset($_GET['examName'])) {
    $sort = $_GET['_sort'];
    $examName = $_GET['examName'];
    $totalPage = ceil(count(getRows('SELECT * FROM questions WHERE difficulty = :difficulty AND chuDe = :chuDe', ["difficulty" => $sort, "chuDe" => $examName])) / $limit);
    $questions = getRows("SELECT * FROM questions WHERE difficulty = :difficulty AND chuDe = :chuDe LIMIT $start, $limit", ["difficulty" => $sort, "chuDe" => $examName]);
}

$examNames = getRows("SELECT * FROM exam WHERE status = 1");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ôn thi trắc nghiệm Ô tô</title>
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
                    <div class="col l-3 c-3">
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
                                    <input type="hidden" name="action" value="ontap">
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
                                        <label for="_sort">Sắp xếp theo độ khó</label>
                                        <div class="form-check ml-5">
                                            <input class="form-check-input" type="radio" name="_sort" id="easy" value="easy" <?php echo isset($_GET['_sort']) && $_GET['_sort'] == 'easy' ? 'checked' : ''; ?>>
                                            <label class="form-check-label ml-2" for="easy">
                                                Easy
                                            </label>
                                        </div>
                                        <div class="form-check ml-5">
                                            <input class="form-check-input" type="radio" name="_sort" id="hard" value="hard" <?php echo isset($_GET['_sort']) && $_GET['_sort'] == 'hard' ? 'checked' : ''; ?>>
                                            <label class="form-check-label ml-2" for="hard">
                                                Hard
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Lọc</button>
                                    <a class="btn btn-primary mt-3 ml-4" href="?module=pages&action=ontap">Hủy lọc</a>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col l-6 c-6">
                        <div class="card">
                            <div class="card-header">
                                <h1>Câu hỏi ôn tập</h1>
                            </div>
                            <div class="card-body">
                                <?php
                                $i = 0;
                                foreach ($questions as $question) :
                                ?>
                                    <div class="question">
                                        <p class="question__content"><?= ++$i ?>. <?php echo $question['question']; ?></p>
                                        <ul class="question__answers">
                                            <li class="question__answer">
                                                <label>A. <?php echo $question['optionA']; ?></label>
                                            </li>
                                            <li class="question__answer">
                                                <label>B. <?php echo $question['optionB']; ?></label>
                                            </li>
                                            <li class="question__answer">
                                                <label>C. <?php echo $question['optionC']; ?></label>
                                            </li>
                                            <li class="question__answer">
                                                <label>D. <?php echo $question['optionD']; ?></label>
                                            </li>
                                            <li class="question__answer">
                                                <label class="question__correct">
                                                    Đáp án: <?php echo $question['answer']; ?>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
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
                                <nav aria-label="Page navigation" style="
                                    overflow-x: hidden;
                                    overflow-y: scroll;
                                    max-height: 387px;
                                ">
                                    <ul class="pagination" style="flex-wrap: wrap;">
                                        <?php if ($page > 1) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?module=pages&action=ontap<?= isset($_GET['examName']) ? '&examName=' . $_GET['examName'] : '' ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>"><a class="page-link" href="?module=pages&action=ontap<?= isset($_GET['examName']) ? '&examName=' . $_GET['examName'] : '' ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endfor; ?>

                                        <?php if ($page < $totalPage) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?module=pages&action=ontap<?= isset($_GET['examName']) ? '&examName=' . $_GET['examName'] : '' ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
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

        <?php
        include_once 'client/layout/footer.php';
        ?>
    </div>
</body>

</html>