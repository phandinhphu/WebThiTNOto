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
$users = getRows("SELECT * FROM users LIMIT $start, $limit");

if (isset($_GET['search']) && empty($_GET['_sort'])) {
    $search = $_GET['search'];
    $total = getRows("SELECT * FROM users WHERE userName LIKE '%$search%'");
    $totalPage = ceil(count($total) / $limit);
    $users = getRows("SELECT * FROM users WHERE userName LIKE '%$search%' LIMIT $start, $limit");
}

if (isset($_GET['_sort'])) {
    switch ($_GET['_sort']) {
        case '1':
            $total = getRows("SELECT * FROM users WHERE status = 1");
            $totalPage = ceil(count($total) / $limit);
            $users = getRows("SELECT * FROM users WHERE status = 1 LIMIT $start, $limit");
            break;
        case '0':
            $total = getRows("SELECT * FROM users WHERE status = 0");
            $totalPage = ceil(count($total) / $limit);
            $users = getRows("SELECT * FROM users WHERE status = 0 LIMIT $start, $limit");
            break;
        case 'name-desc':
            $total = getRows("SELECT * FROM users ORDER BY userName DESC");
            $totalPage = ceil(count($total) / $limit);
            $users = getRows("SELECT * FROM users ORDER BY userName DESC LIMIT $start, $limit");
            break;
        case 'name-asc':
            $total = getRows("SELECT * FROM users ORDER BY userName ASC");
            $totalPage = ceil(count($total) / $limit);
            $users = getRows("SELECT * FROM users ORDER BY userName ASC LIMIT $start, $limit");
            break;
        case 'date-desc':
            $total = getRows("SELECT * FROM users ORDER BY createAt DESC");
            $totalPage = ceil(count($total) / $limit);
            $users = getRows("SELECT * FROM users ORDER BY createAt DESC LIMIT $start, $limit");
            break;
        case 'date-asc':
            $total = getRows("SELECT * FROM users ORDER BY createAt ASC");
            $totalPage = ceil(count($total) / $limit);
            $users = getRows("SELECT * FROM users ORDER BY createAt ASC LIMIT $start, $limit");
            break;
        case 'updated-desc':
            $total = getRows("SELECT * FROM users ORDER BY updateAt DESC");
            $totalPage = ceil(count($total) / $limit);
            $users = getRows("SELECT * FROM users ORDER BY updateAt DESC LIMIT $start, $limit");
            break;
        case 'updated-asc':
            $total = getRows("SELECT * FROM users ORDER BY updateAt ASC");
            $totalPage = ceil(count($total) / $limit);
            $users = getRows("SELECT * FROM users ORDER BY updateAt ASC LIMIT $start, $limit");
            break;
        }
}

if (isset($_GET['_sort']) && isset($_GET['search'])) {
    $search = $_GET['search'];
    $newUsers = [];
    foreach ($users as $user) {
        $name1 = strtolower($user['userName']);
        $name2 = strtolower($search);
        if (strpos($name1, $name2) !== false) {
            array_push($newUsers, $user);
        }
    }
    $users = $newUsers;
}

$examNames = getRows("SELECT * FROM exam");
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="header">
                <div>
                    <h1>Quản lý tài khoản</h1>
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
                            <option value="1"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 1) {
                                echo 'selected';
                            } ?>
                            >Đã kích hoạt</option>
                            <option value="0"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 0) {
                                echo 'selected';
                            } ?>
                            >Chưa kích hoạt</option>
                            <option value="name-desc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'name-desc') {
                                echo 'selected';
                            } ?>
                            >Tên giảm dần</option>
                            <option value="name-asc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'name-asc') {
                                echo 'selected';
                            } ?>
                            >Tên tăng dần</option>
                            <option value="date-desc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'date-desc') {
                                echo 'selected';
                            } ?>
                            >Ngày tham gia giảm dần</option>
                            <option value="date-asc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'date-asc') {
                                echo 'selected';
                            } ?>
                            >Ngày tham gia tăng dần</option>
                            <option value="updated-desc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'updated-desc') {
                                echo 'selected';
                            } ?>
                            >Ngày updated giảm dần</option>
                            <option value="updated-asc"
                            <?php if (isset($_GET['_sort']) && $_GET['_sort'] == 'updated-asc') {
                                echo 'selected';
                            } ?>
                            >Ngày updated tăng dần</option>
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
                    <button id="add-user" class="btn btn-primary">Thêm account</button>
                </div>
            </div>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ngày tham gia</th>
                        <th>Ngày updated</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="list-question">
                    <?php
                    $i = 0;
                    foreach ($users as $user) : ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= $user['userName'] ?></td>
                            <td><?= $user['createAt'] ?></td>
                            <td><?= $user['updateAt'] ?></td>
                            <td><?= $user['status'] == 1 ? "Đã kích hoạt" : "Chưa kích hoạt" ?></td>
                            <td>
                                <button type="button" class="btn btn-primary js-edit-user" value="<?= $user['id'] ?>">Sửa</button>
                                <button type="button" class="btn btn-danger js-delete-user" value="<?= $user['id'] ?>">Xóa</button>
                                <button type="button" class="btn btn-cyan js-rpw-user" value="<?= $user['id'] ?>">Đổi mật khẩu</button>
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
            <a href="?layout=account&page=<?= $page - 1 ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__prev">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php } ?>

        <?php
        for ($i = 1; $i <= $totalPage; $i++) {
        ?>
            <a href="?layout=account&page=<?= $i ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
        <?php } ?>

        <?php
        if ($page < $totalPage) {
        ?>
            <a href="?layout=account&page=<?= $page + 1 ?><?= isset($_GET['_sort']) ? '&_sort=' . $_GET['_sort'] : '' ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__next">
                <i class="fa fa-arrow-right"></i>
            </a>
        <?php } ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>