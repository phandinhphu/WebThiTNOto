<?php
$limit = 15;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

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
    if ($sort == 'hard' || $sort == 'easy') {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE difficulty = '$sort'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE difficulty = '$sort' LIMIT $start, $limit");
    } else {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE chuDe = '$sort'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE chuDe = '$sort' LIMIT $start, $limit");
    }
}

if (isset($_GET['_sort']) && isset($_GET['search'])) {
    $sort = $_GET['_sort'];
    $search = $_GET['search'];
    if ($sort == 'hard' || $sort == 'easy') {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE difficulty = '$sort' AND question LIKE '%$search%'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE difficulty = '$sort' AND question LIKE '%$search%' LIMIT $start, $limit");
    } else {
        $totalPage = ceil(count(getRows("SELECT * FROM questions WHERE chuDe = '$sort' AND question LIKE '%$search%'")) / $limit);
        $questions = getRows("SELECT * FROM questions WHERE chuDe = '$sort' AND question LIKE '%$search%' LIMIT $start, $limit");
    }
}

$examNames = getRows("SELECT * FROM exam");
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="header">
                <div>
                    <h1>Quản lý câu hỏi</h1>
                    <label for="sorted">
                        <strong>Filter</strong>
                        <i class="fa fa-filter" aria-hidden="true"></i>
                    </label>
                    <form action="?layout=question" method="get">
                        <input type="hidden" name="layout" value="question">
                        <?php if (isset($_GET['search'])) { ?>
                            <input type="hidden" name="search" value="<?= $_GET['search'] ?>">
                        <?php } ?>
                        <select name="_sort" id="sorted">
                            <option value="hard"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'hard') {
                                echo 'selected';
                            } ?>
                            >Khó nhất</option>
                            <option value="easy"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'easy') {
                                echo 'selected';
                            } ?>
                            >Dễ nhất</option>
                            <?php foreach ($examNames as $examName) : ?>
                                <option value="<?= $examName['examName'] ?>"
                                <?php if (isset($_GET['_sort']) && $_GET['_sort'] == $examName['examName']) {
                                    echo 'selected';
                                } ?>
                                ><?= $examName['examName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-primary" type="submit">Apply Filter</button>
                        <a href="?layout=question" class="btn btn-danger">Cancel Filter</a>
                    </form>
                </div>
                <div class="search__group">
                    <form role="search" class="form__search" action="?layout=question" method="get">
                        <input type="hidden" name="layout" value="question">
                        <?php if (isset($_GET['_sort'])) { ?>
                            <input type="hidden" name="_sort" value="<?= $_GET['_sort'] ?>">
                        <?php } ?>
                        <input id="search-question" type="text" placeholder="Search..." class="form-control mt-0" name="search" required>
                        <button type="submit" id="search" class="btn-search active">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                    <button id="add-question" class="btn btn-primary">Thêm câu hỏi</button>
                </div>
            </div>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Câu hỏi</th>
                        <th>Chủ đề</th>
                        <th>Độ khó</th>
                        <th>Câu trả lời đúng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="list-question">
                    <?php
                    $i = 0;
                    foreach ($questions as $question) : ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= $question['question'] ?></td>
                            <td><?= $question['chuDe'] ?></td>
                            <td><?= $question['difficulty'] ?></td>
                            <td><?= $question['answer'] ?></td>
                            <td>
                                <button type="button" class="btn btn-primary js-edit-question" value="<?= $question['id'] ?>">Sửa</button>
                                <button type="button" class="btn btn-danger js-delete-question" value="<?= $question['id'] ?>">Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination">
        <?php
        if ($page > 1) {
        ?>
            <a href="?layout=question&page=<?= $page - 1 ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__prev">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php } ?>

        <?php
        for ($i = 1; $i <= $totalPage; $i++) {
        ?>
            <a href="?layout=question&page=<?= $i ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
        <?php } ?>

        <?php
        if ($page < $totalPage) {
        ?>
            <a href="?layout=question&page=<?= $page + 1 ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__next">
                <i class="fa fa-arrow-right"></i>
            </a>
        <?php } ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>