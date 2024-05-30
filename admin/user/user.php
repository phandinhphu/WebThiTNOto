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
    $users = getRows("SELECT * FROM result WHERE userName LIKE '%$search%' LIMIT $start, $limit");
}

// if (isset($_GET['_sort'])) {
//     switch ($_GET['_sort']) {
//         case '1':
//             $total = getRows("SELECT * FROM users WHERE status = 1");
//             $totalPage = ceil(count($total) / $limit);
//             $users = getRows("SELECT * FROM users WHERE status = 1 LIMIT $start, $limit");
//             break;
//         case '0':
//             $total = getRows("SELECT * FROM users WHERE status = 0");
//             $totalPage = ceil(count($total) / $limit);
//             $users = getRows("SELECT * FROM users WHERE status = 0 LIMIT $start, $limit");
//             break;
//         case 'name-desc':
//             $total = getRows("SELECT * FROM users ORDER BY userName DESC");
//             $totalPage = ceil(count($total) / $limit);
//             $users = getRows("SELECT * FROM users ORDER BY userName DESC LIMIT $start, $limit");
//             break;
//         case 'name-asc':
//             $total = getRows("SELECT * FROM users ORDER BY userName ASC");
//             $totalPage = ceil(count($total) / $limit);
//             $users = getRows("SELECT * FROM users ORDER BY userName ASC LIMIT $start, $limit");
//             break;
//         case 'date-desc':
//             $total = getRows("SELECT * FROM users ORDER BY createAt DESC");
//             $totalPage = ceil(count($total) / $limit);
//             $users = getRows("SELECT * FROM users ORDER BY createAt DESC LIMIT $start, $limit");
//             break;
//         case 'date-asc':
//             $total = getRows("SELECT * FROM users ORDER BY createAt ASC");
//             $totalPage = ceil(count($total) / $limit);
//             $users = getRows("SELECT * FROM users ORDER BY createAt ASC LIMIT $start, $limit");
//             break;
//         case 'updated-desc':
//             $total = getRows("SELECT * FROM users ORDER BY updateAt DESC");
//             $totalPage = ceil(count($total) / $limit);
//             $users = getRows("SELECT * FROM users ORDER BY updateAt DESC LIMIT $start, $limit");
//             break;
//         case 'updated-asc':
//             $total = getRows("SELECT * FROM users ORDER BY updateAt ASC");
//             $totalPage = ceil(count($total) / $limit);
//             $users = getRows("SELECT * FROM users ORDER BY updateAt ASC LIMIT $start, $limit");
//             break;
//         }
// }

// if (isset($_GET['_sort']) && isset($_GET['search'])) {
//     $search = $_GET['search'];
//     $newUsers = [];
//     foreach ($users as $user) {
//         $name1 = strtolower($user['userName']);
//         $name2 = strtolower($search);
//         if (strpos($name1, $name2) !== false) {
//             array_push($newUsers, $user);
//         }
//     }
//     $users = $newUsers;
// }

?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="header">
                <div>
                    <h1>Quản lý người dùng</h1>
                    <label for="sorted">
                        <strong>Filter</strong>
                        <i class="fa fa-filter" aria-hidden="true"></i>
                    </label>
                    <form action="?layout=account" method="get">
                        <input type="hidden" name="layout" value="account">
                        <?php if (isset($_GET['search'])) { ?>
                            <input type="hidden" name="search" value="<?= $_GET['search'] ?>">
                        <?php } ?>
                        <select name="_sort" id="sorted">
                            <option value="name-desc">Tên (Z-A)</option>
                            <option value="name-asc">Tên (A-Z)</option>
                            <option value="total-test-desc">Tổng bài làm (cao đến thấp)</option>
                            <option value="total-test-asc">Tổng bài làm (thấp đến cao)</option>
                            <option value="total-pass-desc">Tổng bài đậu (cao đến thấp)</option>
                            <option value="total-pass-asc">Tổng bài đậu (thấp đến cao)</option>
                            <option value="total-fail-desc">Tổng bài rớt (cao đến thấp)</option>
                            <option value="total-fail-asc">Tổng bài rớt (thấp đến cao)</option>
                        </select>
                        <button class="btn btn-primary" type="submit">Apply Filter</button>
                        <a href="?layout=account" class="btn btn-danger">Cancel Filter</a>
                    </form>
                </div>
                <div class="search__group">
                    <form role="search" class="form__search" action="?layout=account" method="get">
                        <input type="hidden" name="layout" value="account">
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
                        $res = getTotalPassAndFail($user['id']);
                    ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= $res['userName'] ?></td>
                            <td><?= $res['Total Test'] ?></td>
                            <td><?= $res['Total Pass'] ?></td>
                            <td><?= $res['Total Failure'] ?></td>
                            <td>
                                <button class="btn btn-cyan js-btn-detail" value="<?= $user['id'] ?>">Xem chi tiết</button>
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