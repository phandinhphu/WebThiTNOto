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

if (isset($_GET['search']) && empty($_GET['_sort'])) {
    $search = $_GET['search'];
    $total = getRows("SELECT * FROM questions WHERE question LIKE '%$search%'");
    $totalPage = ceil(count($total) / $limit);
    $questions = getRows("SELECT * FROM questions WHERE question LIKE '%$search%' LIMIT $start, $limit");
}

if (isset($_GET['_sort']) && empty($_GET['search'])) {
    $sort = $_GET['_sort'];
    if ($sort == 'hard') {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE difficulty = 'hard'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE difficulty = 'hard' LIMIT $start, $limit");
    } elseif ($sort == 'easy') {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE difficulty = 'easy'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE difficulty = 'easy' LIMIT $start, $limit");
    } else {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE chuDe = '$sort'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE chuDe = '$sort' LIMIT $start, $limit");
    }
}

if (isset($_GET['_sort']) && isset($_GET['search'])) {
    $sort = $_GET['_sort'];
    $search = $_GET['search'];
    if ($sort == 'hard') {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE difficulty = 'hard' AND question LIKE '%$search%'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE difficulty = 'hard' AND question LIKE '%$search%' LIMIT $start, $limit");
    } elseif ($sort == 'easy') {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE difficulty = 'easy' AND question LIKE '%$search%'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE difficulty = 'easy' AND question LIKE '%$search%' LIMIT $start, $limit");
    } else {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE chuDe = '$sort' AND question LIKE '%$search%'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE chuDe = '$sort' AND question LIKE '%$search%' LIMIT $start, $limit");
    }
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
    <link rel="stylesheet" href="client/assets/css/grid.css">
    <link rel="stylesheet" href="client/assets/css/main.css">
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
                        <div class="app__sidebar">
                            <div class="app__sidebar-heading">
                                <h3 class="app__sidebar-heading-title">Bài thi</h3>
                            </div>
                            <div class="app__sidebar-content">
                                <ul class="app__sidebar-list">
                                    <?php
                                    foreach ($examNames as $examName) :
                                    ?>
                                        <li class="app__sidebar-item">
                                            <a href="?client=pages&action=ontap&_sort=<?= $examName['examName'] ?>" class="app__sidebar-link"><?= $examName['examName'] ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col l-9 c-9">
                        <div class="wrapper">
                            <h1>Câu hỏi ôn tập</h1>
                            <!-- sort -->
                            <div class="sort">
                                <form action="?client=pages&action=ontap" method="GET">
                                    <input type="hidden" name="client" value="pages">
                                    <input type="hidden" name="action" value="ontap">
                                    <select name="_sort" class="sort__select">
                                        <option value="easy" <?= isset($_GET['_sort']) && $_GET['_sort'] == 'easy' ? 'selected' : '' ?>>Easy</option>
                                        <option value="hard" <?= isset($_GET['_sort']) && $_GET['_sort'] == 'hard' ? 'selected' : '' ?>>Hard</option>
                                    </select>
                                    <button type="submit" class="sort__btn">Sắp xếp</button>
                                </form>
                            </div>
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
                        <div class="pagination">
                            <?php
                            if ($page > 1) {
                            ?>
                                <a href="?client=pages&action=ontap&page=<?= $page - 1 ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__prev">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            <?php } ?>

                            <?php
                            for ($i = 1; $i <= $totalPage; $i++) {
                            ?>
                                <a href="?client=pages&action=ontap&page=<?= $i ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
                            <?php } ?>

                            <?php
                            if ($page < $totalPage) {
                            ?>
                                <a href="?client=pages&action=ontap&page=<?= $page + 1 ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__next">
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            <?php } ?>
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