<?php
$total = getRows('SELECT * FROM questions');
$limit = 15;
$totalPage = ceil(count($total) / $limit);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$start = ($page - 1) * $limit;

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $questions = getRows("SELECT * FROM questions WHERE question LIKE '%$search%' LIMIT $start, $limit");
} else {
    $questions = getRows("SELECT * FROM questions LIMIT $start, $limit");
}
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="header">
                <h1>Quản lý câu hỏi</h1>
                <div class="search__group">
                    <form role="search" class="form__search" action="?layout=question" method="get">
                        <input type="text" placeholder="Search..." class="form-control mt-0" name="search">
                        <a href="" class="active">
                            <i class="fa fa-search"></i>
                        </a>
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
            <a href="?layout=question&page=<?= $page - 1 ?>
                            <?= isset($_GET['id']) ? '&id=' . $_GET['id'] : '' ?>
                            <?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__prev">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php } ?>

        <?php
        for ($i = 1; $i <= $totalPage; $i++) {
        ?>
            <a href="?layout=question&page=<?= $i ?>
                            <?= isset($_GET['id']) ? '&id=' . $_GET['id'] : '' ?>
                            <?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
        <?php } ?>

        <?php
        if ($page < $totalPage) {
        ?>
            <a href="?layout=question&page=<?= $page + 1 ?>
                            <?= isset($_GET['id']) ? '&id=' . $_GET['id'] : '' ?>
                            <?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__next">
                <i class="fa fa-arrow-right"></i>
            </a>
        <?php } ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>