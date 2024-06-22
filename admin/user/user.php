<?php
$limit = 15;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$start = ($page - 1) * $limit;

$total = getRows("SELECT * FROM users");
$totalPage = ceil(count($total) / $limit);
$users = getRows("SELECT id FROM users LIMIT $start, $limit");

if (isset($_GET['search']) && empty($_GET['_sort'])) {
    $search = $_GET['search'];
    $total = getRows("SELECT * FROM users WHERE userName LIKE '%$search%'");
    $totalPage = ceil(count($total) / $limit);
    $users = getRows("SELECT * FROM users WHERE userName LIKE '%$search%' LIMIT $start, $limit");
}

$userTmpl = [];
foreach ($users as $user) {
    $res = getTotalPassAndFail($user['id']);
    $userTmpl[] = array_merge($user, $res);
}
$users = $userTmpl;

if (isset($_GET['_sort'])) {
    $sort = $_GET['_sort'];
    switch ($sort) {
        case 'name-desc':
            usort($users, function ($a, $b) {
                return $b['userName'] <=> $a['userName'];
            });
            break;
        case 'name-asc':
            usort($users, function ($a, $b) {
                return $a['userName'] <=> $b['userName'];
            });
            break;
        case 'total-test-desc':
            usort($users, function ($a, $b) {
                return $b['Total Test'] <=> $a['Total Test'];
            });
            break;
        case 'total-test-asc':
            usort($users, function ($a, $b) {
                return $a['Total Test'] <=> $b['Total Test'];
            });
            break;
        case 'total-pass-desc':
            usort($users, function ($a, $b) {
                return $b['Total Pass'] <=> $a['Total Pass'];
            });
            break;
        case 'total-pass-asc':
            usort($users, function ($a, $b) {
                return $a['Total Pass'] <=> $b['Total Pass'];
            });
            break;
        case 'total-fail-desc':
            usort($users, function ($a, $b) {
                return $b['Total Failure'] <=> $a['Total Failure'];
            });
            break;
        case 'total-fail-asc':
            usort($users, function ($a, $b) {
                return $a['Total Failure'] <=> $b['Total Failure'];
            });
            break;
    }
}

if (isset($_GET['_sort']) && isset($_GET['search'])) {
    $search = $_GET['search'];
    $newUsers = [];
    foreach ($users as $user) {
        $name1 = strtolower(removeAccent($user['userName']));
        $name2 = strtolower(removeAccent($search));
        if (strpos($name1, $name2) !== false) {
            $newUsers[] = $user;
        }
    }
    $users = $newUsers;
}

?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="header">
                <div>
                    <h1>Quản lý các bài thi của người dùng</h1>
                    <label for="sorted">
                        <strong>Filter</strong>
                        <i class="fa fa-filter" aria-hidden="true"></i>
                    </label>
                    <form action="?layout=user" method="get">
                        <input type="hidden" name="layout" value="user">
                        <?php if (isset($_GET['search'])) { ?>
                            <input type="hidden" name="search" value="<?= $_GET['search'] ?>">
                        <?php } ?>
                        <select name="_sort" id="sorted"
                        >
                            <option value="name-desc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'name-desc') {
                                echo 'selected';
                            } ?>
                            >Tên (Z-A)</option>
                            <option value="name-asc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'name-asc') {
                                echo 'selected';
                            } ?>
                            >Tên (A-Z)</option>
                            <option value="total-test-desc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'total-test-desc') {
                                echo 'selected';
                            } ?>
                            >Tổng bài làm (giảm dần)</option>
                            <option value="total-test-asc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'total-test-asc') {
                                echo 'selected';
                            } ?>
                            >Tổng bài làm (tăng dần)</option>
                            <option value="total-pass-desc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'total-pass-desc') {
                                echo 'selected';
                            } ?>
                            >Tổng bài đậu (giảm dần)</option>
                            <option value="total-pass-asc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'total-pass-asc') {
                                echo 'selected';
                            } ?>
                            >Tổng bài đậu (tăng dần)</option>
                            <option value="total-fail-desc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'total-fail-desc') {
                                echo 'selected';
                            } ?>
                            >Tổng bài rớt (giảm dần)</option>
                            <option value="total-fail-asc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'total-fail-asc') {
                                echo 'selected';
                            } ?>
                            >Tổng bài rớt (tăng dần)</option>
                        </select>
                        <button class="btn btn-primary" type="submit">Apply Filter</button>
                        <a href="?layout=user" class="btn btn-danger">Cancel Filter</a>
                    </form>
                </div>
                <div class="search__group">
                    <form role="search" class="form__search" action="?layout=user" method="get">
                        <input type="hidden" name="layout" value="user">
                        <?php if (isset($_GET['_sort'])) { ?>
                            <input type="hidden" name="_sort" value="<?= $_GET['_sort'] ?>">
                        <?php } ?>
                        <input id="search-question" type="text" placeholder="Search..." class="form-control mt-0" name="search" required>
                        <button type="submit" id="search" class="btn-search active">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Tổng bài làm</th>
                        <th>Tổng bài đậu</th>
                        <th>Tổng bài rớt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="list-question">
                    <?php
                    $i = 0;
                    foreach ($users as $user) :
                    ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= $user['userName'] ?></td>
                            <td><?= $user['Total Test'] ?></td>
                            <td><?= $user['Total Pass'] ?></td>
                            <td><?= $user['Total Failure'] ?></td>
                            <td>
                                <button class="btn btn-cyan js-btn-detail" value="<?= $user['id'] ?>"
                                <?php if ($user['Total Test'] == 0) { ?>
                                    style="
                                            pointer-events: none;
                                            color: #fff;
                                            background-color: #ccc;
                                            border-color: #ccc;
                                            "
                                <?php } ?>
                                >Xem chi tiết</button>
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
            <a href="?layout=user&page=<?= $page - 1 ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__prev">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php } ?>

        <?php
        for ($i = 1; $i <= $totalPage; $i++) {
        ?>
            <a href="?layout=user&page=<?= $i ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
        <?php } ?>

        <?php
        if ($page < $totalPage) {
        ?>
            <a href="?layout=user&page=<?= $page + 1 ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__next">
                <i class="fa fa-arrow-right"></i>
            </a>
        <?php } ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>