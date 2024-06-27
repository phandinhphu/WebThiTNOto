<?php
$exams = getRows('SELECT * FROM exam');
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="header">
                <h1>Quản lý bài thi</h1>
                <button id="add-exam" class="btn btn-primary">Thêm bài thi</button>
            </div>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Tên bài thi</th>
                        <th>Thời gian làm bài(phút)</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($exams as $exam) : ?>
                        <tr>
                            <td><?= $exam['examName'] ?></td>
                            <td><?= $exam['timeLimit'] ?></td>
                            <td><?= $exam['createdAt'] ?></td>
                            <td><?= $exam['updatedAt'] ?></td>
                            <td style="color: <?= ($exam['status'] == 1) ? 'green' : 'red' ?>;">
                                <?= ($exam['status'] == 1) ? 'Active' : 'Inactive' ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary js-edit-exam" value="<?= $exam['examName'] ?>">Sửa</button>
                                <button type="button" class="btn btn-danger js-delete-exam" value="<?= $exam['examName'] ?>">Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>