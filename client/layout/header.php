<?php
$exams = getRows('SELECT * FROM exam');
?>
<header>
    <div class="header">
        <div class="header__heading">
            <a href="index.php">
                <h1>Thi Lái Xe Ô tô</h1>
            </a>
        </div>
        <div class="header__menu">
            <ul class="first__list">
                <li class="first__items">
                    <a class="first__items-link" href="?client=pages&action=trangchu">Trang chủ</a>
                </li>
                <li class="first__items">
                    <a class="first__items-link" href="index.php?client=pages&action=ontap">Ôn tập</a>
                </li>
                <li class="first__items">
                    <a class="first__items-link" href="#">Thi thử</a>
                    <ul class="context__list">
                        <?php foreach ($exams as $exam) : ?>
                            <li class="context__items">
                                <a class="context__items-link" href="index.php?client=pages&action=thithu&exam_name=<?php echo $exam['examName']; ?>"><?php echo $exam['examName']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="first__items">
                    <a class="first__items-link" href="index.php?client=pages&action=about">Giới thiệu</a>
                </li>
                <li class="first__items">
                    <a class="first__items-link" href="index.php?client=pages&action=contact">Liên hệ</a>
                </li>
            </ul>
        </div>
    </div>
</header>