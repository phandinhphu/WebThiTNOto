<?php
$examsMenu = getRows('SELECT * FROM exam WHERE status = 1');
?>
<header>
    <div class="header">
        <div class="header__first">
            <a href="?module=pages&action=trangchu">
                <h1>Thi Lái Xe Ô tô</h1>
            </a>
            <div class="header__menu">
                <ul class="first__list">
                    <li class="first__items">
                        <a class="first__items-link" href="?module=pages&action=trangchu">Trang chủ</a>
                    </li>
                    <li class="first__items">
                        <a class="first__items-link" href="?module=pages&action=ontap">Ôn tập</a>
                    </li>
                    <li class="first__items">
                        <a class="first__items-link" href="?module=pages&action=thithu">Thi thử</a>
                        <ul class="context__list">
                            <?php foreach ($examsMenu as $exam) : ?>
                                <li class="context__items">
                                    <a class="context__items-link" href="?module=pages&action=thithu&exam_name=<?php echo $exam['examName']; ?>"><?php echo $exam['examName']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="first__items">
                        <a class="first__items-link" href="?module=pages&action=historyQuestion">Lịch sử</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="header__second">
            <div class="header__second-user">
                <?php if (isset($_SESSION['user'])) : ?>
                    <span class="header__second-user-name"><?php echo $_SESSION['user']['userName']; ?></span>
                <?php endif; ?>
                <div class="header__second-user-menu">
                    <ul class="second__list">
                        <li class="second__items">
                            <a class="second__items-link" href="?module=pages&action=profile">Thông tin cá nhân</a>
                        </li>
                        <li class="second__items">
                            <a class="second__items-link" href="?module=auth&action=logout">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>