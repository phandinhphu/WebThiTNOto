<?php
$questions = getRows('SELECT * FROM questions');
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="header">
                <h1>Quản lý câu hỏi</h1>
                <button id="add-exam" class="btn btn-primary">Thêm câu hỏi</button>
            </div>
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Câu hỏi</th>
                        <th>Chủ đề</th>
                        <th>Độ khó</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($questions as $question) : ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= $question['question'] ?></td>
                            <td><?= $question['chuDe'] ?></td>
                            <td><?= $question['difficulty'] ?></td>
                            <td>
                                <button type="button" class="btn btn-cyan js-show-question" value="<?= $question['question'] ?>">Xem</button>
                                <button type="button" class="btn btn-primary js-edit-question" value="<?= $question['question'] ?>">Sửa</button>
                                <button type="button" class="btn btn-danger js-delete-question" value="<?= $question['question'] ?>">Xóa</button>
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