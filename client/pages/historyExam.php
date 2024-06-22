<?php
$limit = 15;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$exams = getRows('SELECT * FROM result
                WHERE  userId = :userId
                LIMIT ' . $start . ', ' . $limit, ['userId' => $_SESSION['user']['id']]);


$total = getRow('SELECT count(*) as total FROM result WHERE userId = :userId', ['userId' => $_SESSION['user']['id']]);
$total_records = $total['total'];
$total_pages = ceil($total_records / $limit);

if (isset($_GET['examName']) && empty($_GET['testDate'])) {
    $total = getRow('SELECT count(*) as total FROM result
                    WHERE userId = :userId and examName = :examName', ['userId' => $_SESSION['user']['id'], 'examName' => $_GET['examName']]);
    $total_pages = ceil($total['total'] / $limit);
    $exams = getRows('SELECT * FROM result
                        WHERE userId = :userId and examName = :examName
                        ORDER BY testDate DESC LIMIT ' . $start . ', ' . $limit, ['userId' => $_SESSION['user']['id'], 'examName' => $_GET['examName']]);
} elseif (isset($_GET['testDate']) && empty($_GET['examName'])) {
    $exams = getRows('SELECT * FROM result
                        WHERE userId = :userId
                        ORDER BY testDate ' . $_GET['testDate'] . ' LIMIT ' . $start . ', ' . $limit, ['userId' => $_SESSION['user']['id']]);
} elseif (isset($_GET['examName']) && isset($_GET['testDate'])) {
    $total = getRow('SELECT count(*) as total FROM result
                    WHERE userId = :userId and examName = :examName', ['userId' => $_SESSION['user']['id'], 'examName' => $_GET['examName']]);
    $total_pages = ceil($total['total'] / $limit);
    $exams = getRows('SELECT * FROM result
                        WHERE userId = :userId and examName = :examName
                        ORDER BY testDate ' . $_GET['testDate'] . ' LIMIT ' . $start . ', ' . $limit, ['userId' => $_SESSION['user']['id'], 'examName' => $_GET['examName']]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL.'client/assets/css/grid.css' ?>">
    <link rel="stylesheet" href="<?= BASE_URL.'client/assets/css/main.css' ?>">
    <script src="<?= BASE_URL.'client/assets/js/logout.js' ?>"></script>
</head>

<body>
    <div class="app">
        <?php
        include_once 'client/layout/header.php';
        ?>

        <div class="app__container">
            <div class="grid wide">
                <div class="row">
                    <div class="col c-3">
                        <div class="card">
                            <div class="card-header">
                                <h3>Lịch sử</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a class="list-group-link" href="?module=pages&action=historyQuestion">Lịch sử câu hỏi</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="list-group-link" href="?module=pages&action=historyExam">Lịch sử bài thi</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3>
                                    Filter
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
                                    <input type="hidden" name="module" value="pages">
                                    <input type="hidden" name="action" value="historyExam">
                                    <div class="form-group">
                                        <label for="examName">Chọn bài thi</label>
                                        <?php
                                        $examsFilter = getRows('SELECT * FROM exam WHERE status = 1');
                                        foreach ($examsFilter as $exam) : ?>
                                            <div class="form-check ml-5">
                                                <input class="form-check-input" type="radio" name="examName" id="<?php echo $exam['examName']; ?>" value="<?php echo $exam['examName']; ?>" <?php echo isset($_GET['examName']) && $_GET['examName'] == $exam['examName'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label ml-2" for="<?php echo $exam['examName']; ?>">
                                                    <?php echo $exam['examName']; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="testDate">Sắp xếp theo ngày làm bài</label>
                                        <div class="form-check ml-5">
                                            <input class="form-check-input" type="radio" name="testDate" id="asc" value="asc" <?php echo isset($_GET['testDate']) && $_GET['testDate'] == 'asc' ? 'checked' : ''; ?>>
                                            <label class="form-check-label ml-2" for="asc">
                                                Tăng dần
                                            </label>
                                        </div>
                                        <div class="form-check ml-5">
                                            <input class="form-check-input" type="radio" name="testDate" id="desc" value="desc" <?php echo isset($_GET['testDate']) && $_GET['testDate'] == 'desc' ? 'checked' : ''; ?>>
                                            <label class="form-check-label ml-2" for="desc">
                                                Giảm dần
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Lọc</button>
                                    <a class="btn btn-primary mt-3 ml-4" href="?module=pages&action=historyExam">Hủy lọc</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col c-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Lịch sử làm bài</h3>
                                <div class="alert" role="alert">
                                    <strong></strong>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="form-profile">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Tên bài thi</th>
                                                <th scope="col">Điểm</th>
                                                <th scope="col">Time complete</th>
                                                <th scope="col">Test date</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($exams as $key => $exam) : ?>
                                                <tr>
                                                    <th scope="row"><?php echo $key + 1; ?></th>
                                                    <td><?php echo $exam['examName']; ?></td>
                                                    <td><?php echo $exam['score']; ?>/100</td>
                                                    <td><?php echo $exam['timeComplete']; ?></td>
                                                    <td><?php echo $exam['testDate']; ?></td>
                                                    <td style="
                                                        display: flex;
                                                    ">
                                                        <button class="btn btn-primary btn-detail" value="<?= $exam['userId'] ?>" test-date="<?= $exam['testDate'] ?>" >Chi tiết</button>
                                                        <button class="btn btn-success btn-export ml-2" test-date="<?= $exam['testDate'] ?>" >Export excel</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col c-3" style="
                        position: fixed;
                        right: 0;
                    ">
                        <div class="card">
                            <div class="card-header">
                                <h3>Phân trang</h3>
                            </div>
                            <div class="card-body">
                                <nav aria-label="Page navigation" style="
                                    overflow-x: hidden;
                                    overflow-y: scroll;
                                    max-height: 387px;
                                ">
                                    <ul class="pagination" style="flex-wrap: wrap;">
                                        <?php if ($page > 1) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?module=pages&action=historyExam<?= isset($_GET['examName']) ? '&examName=' . $_GET['examName'] : '' ?><?= isset($_GET['testDate']) ? '&testDate=' . $_GET['testDate'] : '' ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>"><a class="page-link" href="?module=pages&action=historyExam<?= isset($_GET['examName']) ? '&examName=' . $_GET['examName'] : '' ?><?= isset($_GET['testDate']) ? '&testDate=' . $_GET['testDate'] : '' ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?module=pages&action=historyExam<?= isset($_GET['examName']) ? '&examName=' . $_GET['examName'] : '' ?><?= isset($_GET['testDate']) ? '&testDate=' . $_GET['testDate'] : '' ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="End">
                                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once 'client/layout/footer.php';
    ?>

    <div class="modal fade" id="modalDetail" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="font-size: 2.2rem;">Chi tiết</h4>
                </div>
                <div class="modal-body" style="
                    font-size: 1.4rem;
                    overflow: scroll;
                    height: 400px;
                    overflow-y: scroll;
                    overflow-x: hidden;
                ">
                    <div id="list-answer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        const btnDetail = document.querySelectorAll('.btn-detail');
        btnDetail.forEach(item => {
            item.addEventListener('click', async () => {
                let userId = item.getAttribute('value');
                let testDate = item.getAttribute('test-date');
                const response = await fetch(`http://localhost/WebThiTN-Oto/api/question/getQuestionByTestDate.php?testDate=${testDate}&userId=${userId}`);
                const {
                    data: questions
                } = await response.json();
    
                const listAnswerDOM = document.getElementById('list-answer');
                listAnswerDOM.innerHTML = '';
                questions.forEach((question, index) => {
                    const div = document.createElement('div');
                    div.classList.add('divst-group-item');
                    div.innerHTML = `
                        <div class="panel-heading">Câu hỏi ${index + 1}</div>
                        <div class="panel-body" style="color: ${question.result === 0 ? 'red' : 'green'}">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            ${question.question}
                        </div>
                        <div class="panel-footer">
                            <div class="radio" style="
                                display: flex;
                                flex-direction: column;
                            ">
                                <label><input class="mr-2" type="radio" value="A" name="group-${question.id}" ${
                                    question.answerUser === 'A' ? 'checked' : ''
                                } disabled>A. ${question.optionA}</label>
    
                                <label><input class="mr-2" type="radio" value="B" name="group-${question.id}" ${
                                    question.answerUser === 'B' ? 'checked' : ''
                                } disabled>B. ${question.optionB}</label>
    
                                <label><input class="mr-2" type="radio" value="C" name="group-${question.id}" ${
                                    question.answerUser === 'C' ? 'checked' : ''
                                } disabled>C. ${question.optionC}</label>
    
                                <label><input class="mr-2" type="radio" value="D" name="group-${question.id}" ${
                                    question.answerUser === 'D' ? 'checked' : ''
                                } disabled>D. ${question.optionD}</label>
                            </div>
                            <div class="panel-footer">Đáp án đúng: ${question.answer}</div>
                        </div>
                    `;
                    listAnswerDOM.appendChild(div);
                });
    
                $("#modalDetail").modal();
            });
        });
    </script>
    <script>
        const btnExport = document.querySelectorAll('.btn-export');
        btnExport.forEach(item => {
            item.addEventListener('click', async () => {
                let testDate = item.getAttribute('test-date');
                window.location.href = `http://localhost/WebThiTN-Oto/export.php?download=true&testDate=${testDate}`;
            });
        });
    </script>
</body>

</html>