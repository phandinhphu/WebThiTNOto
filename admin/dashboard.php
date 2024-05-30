<?php
$sql = "SELECT exam.*, COUNT(result.id) AS 'soNguoiLam'
        FROM exam left JOIN result
        on result.examName = exam.examName
        GROUP BY exam.examName";

$exams = getRows($sql);

?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <?php foreach($exams as $exam) : ?>
        <div class="col-lg-6 col-md-12">
            <div class="white-box analytics-info">
                <h1 class="box-title"><?php echo $exam['examName']; ?> (Ngày tạo: <?= $exam['createdAt'] ?>)</h1>
                <ul class="list-inline two-part d-flex m-b-0 flex-column">
                    <li class="ms-lg-5">
                        <span class="counter text-dark">
                            Số người làm bài:
                            <?php echo $exam['soNguoiLam']; ?>
                        </span>
                    </li>
                    <li class="ms-lg-5">
                        <span class="counter text-dark">
                            Thời gian làm bài:
                            <?php echo $exam['timeLimit']; ?>
                            phút
                        </span>
                    </li>
                    <li class="ms-lg-5">
                        <span class="counter text-dark">
                            Số câu hỏi:
                            <?php echo $exam['soCauHoi']; ?>
                        </span>
                    </li>
                    <li class="ms-lg-5">
                        <?php 
                            $sql = "SELECT COUNT(result.id) AS 'soNguoiDau'
                                    FROM result
                                    WHERE result.examName = '{$exam['examName']}' AND result.score >= 80";
                            $soNguoiDau = getRow($sql)['soNguoiDau'];
                        ?>
                        <span class="counter text-dark">
                            Số người đậu:
                            <?php echo $soNguoiDau;?>
                        </span>
                    </li>
                    <li class="ms-lg-5">
                        <?php 
                            $sql = "SELECT COUNT(result.id) AS 'soNguoiRot'
                                    FROM result
                                    WHERE result.examName = '{$exam['examName']}' AND result.score < 80";
                            $soNguoiRot = getRow($sql)['soNguoiRot'];
                        ?>
                        <span class="counter text-dark">
                            Số người rớt:
                            <?php echo $soNguoiRot;?>
                        </span>
                    </li>
                    <li class="ms-lg-5">
                        <span class="counter <?= $exam['status'] == 1 ? "text-success" : "text-danger" ?>">
                            Trạng thái:
                            <?= $exam['status'] == 1 ? "Đang mở" : "Đang đóng" ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>