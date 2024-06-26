const btnDetails = document.querySelectorAll('.js-btn-detail');
const btnMangClose = document.getElementById('js-mang-user-close');
const btnMangIconClose = document.getElementById('thong-tin-icon-close');

btnMangClose.addEventListener('click', () => {
    $('#thongTinBaiThiModal').modal('hide');
});

btnMangIconClose.addEventListener('click', () => {
    $('#thongTinBaiThiModal').modal('hide');
});

$(document).on('click', '.js-close-vdetail', function () {
    $('#modalViewResult').modal('hide');
});

$(document).on('click', '.js-close-updateScore', function () {
    $('#modalUpdateScore').modal('hide');
});

btnDetails.forEach((item) => {
    item.addEventListener('click', () => {
        let id = item.getAttribute('value');
        handleShowInfo(id);
    });
});

async function handleShowInfo(id) {
    const request = await fetch(`http://localhost/WebThiTN-Oto/api/result/getResult.php?id=${id}`);
    const { data: result, status } = await request.json();
    if (status == 200) {
        $('#thongTinBaiThiModal').modal('show');
        let html = '';
        result.forEach((item, index) => {
            html += `<tr>
                        <td>${index + 1}</td>
                        <td>${item.examName}</td>
                        <td>${item.soCauHoi}</td>
                        <td>${item.soCauDung}</td>
                        <td>${item.soCauSai}</td>
                        <td>${item.timeComplete}</td>
                        <td>${item.score}</td>
                        <td>${item.ketQua}</td>
                        <td>
                            <button class="btn btn-primary js-view-mngex" value="${item.userId}" test-date="${item.testDate}">Xem</button>
                            <button class="btn btn-cyan js-update-mngex" num-questions="${item.soCauHoi}" value="${item.userId}" test-date="${item.testDate}">Sửa</button>
                            <button class="btn btn-danger js-delete-mngex" value="${item.userId}" test-date="${item.testDate}">Xóa</button>
                        </td>
                    </tr>`;
        });

        $('#thongTinBaiThiModal .modal-body .table tbody').html(html);
    } else {
        alert("Tài khoản này chưa làm bài thi nào");
    }
}

$(document).on('click', '.js-view-mngex', async function () {
    let id = $(this).attr('value');
    $('#modalViewResult').modal('show');
    let userId = $(this).attr('value');
    let testDate = $(this).attr('test-date');
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
            <div class="panel-footer" style="margin-bottom: 8px;">
                <div class="radio" style="
                    display: flex;
                    flex-direction: column;
                ">
                    <label><input class="mr-2" type="radio" value="A" name="group-${question.id}" ${
                        question.answerUser === 'A' ? 'checked' : ''
                    } disabled style="margin-right: 8px;">A. ${question.optionA}</label>

                    <label><input class="mr-2" type="radio" value="B" name="group-${question.id}" ${
                        question.answerUser === 'B' ? 'checked' : ''
                    } disabled style="margin-right: 8px;">B. ${question.optionB}</label>

                    <label><input class="mr-2" type="radio" value="C" name="group-${question.id}" ${
                        question.answerUser === 'C' ? 'checked' : ''
                    } disabled style="margin-right: 8px;">C. ${question.optionC}</label>

                    <label><input class="mr-2" type="radio" value="D" name="group-${question.id}" ${
                        question.answerUser === 'D' ? 'checked' : ''
                    } disabled style="margin-right: 8px;">D. ${question.optionD}</label>
                </div>
                <div class="panel-footer">Đáp án đúng: ${question.answer}</div>
            </div>
        `;
        listAnswerDOM.appendChild(div);
    });
});

$(document).on('click', '.js-update-mngex', function () {
    let id = $(this).attr('value');
    let testDate = $(this).attr('test-date');
    let numQuestions = $(this).attr('num-questions');
    $('#modalUpdateScore').modal('show');
    
    $('#numoftrue').attr('max', numQuestions);
    $('#numoffalse').attr('max', numQuestions);

    $('#js-update-score').attr('value', id);
    $('#js-update-score').attr('test-date', testDate);

    document.getElementById('numoftrue').addEventListener('input', function() {
        if (this.value == '') {
            document.getElementById('numoffalse').value = '';
            document.getElementById('score').value = '';
        } else {
            document.getElementById('numoffalse').value = numQuestions - this.value;
            document.getElementById('score').value = (100 / numQuestions) * this.value;
        }
    });

    document.getElementById('numoffalse').addEventListener('input', function() {
        if (this.value == '') {
            document.getElementById('numoftrue').value = '';
            document.getElementById('score').value = '';
        } else {
            document.getElementById('numoftrue').value = numQuestions - this.value;
            document.getElementById('score').value = (100 / numQuestions) * document.getElementById('numoftrue').value;
        }
    });
});

$(document).on('click', '#js-update-score', async function () {
    let soCauDung = $('#numoftrue').val();
    let soCauSai = $('#numoffalse').val();
    let score = $('#score').val();

    if (soCauDung == '' || soCauSai == '' || score == '') {
        alert("Vui lòng điền đầy đủ thông tin");
        return;
    }

    if (soCauSai < 0) {
        alert("Số câu sai không được nhỏ hơn 0");
        return;
    }

    if (soCauDung < 0) {
        alert("Số câu đúng không được nhỏ hơn 0");
        return;
    }

    let id = $(this).attr('value');
    let testDate = $(this).attr('test-date');

    let data = {
        userId: id,
        testDate: testDate,
        soCauDung: soCauDung,
        soCauSai: soCauSai,
        score: score
    };
    const request = await fetch('http://localhost/WebThiTN-Oto/admin/user/update-exam-user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const { status } = await request.json();
    if (status == 200) {
        alert("Cập nhật thành công");
        location.reload();
    } else {
        alert("Cập nhật thất bại");
    }
});

$(document).on('click', '.js-delete-mngex', async function () {
    let id = $(this).attr('value');
    let testDate = $(this).attr('test-date');

    if (!confirm("Bạn có chắc chắn muốn xóa?")) {
        return;
    }

    let data = {
        userId: id,
        testDate: testDate
    };

    const request = await fetch('http://localhost/WebThiTN-Oto/admin/user/delete-exam-user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const { status, message } = await request.json();
    if (status == 200) {
        alert(message);
        location.reload();
    } else {
        alert(message);
    }
});