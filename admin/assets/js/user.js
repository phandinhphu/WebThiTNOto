const btnDetails = document.querySelectorAll('.js-btn-detail');
const btnMangClose = document.getElementById('js-mang-user-close');
const btnMangIconClose = document.getElementById('thong-tin-icon-close');

btnMangClose.addEventListener('click', () => {
    $('#thongTinBaiThiModal').modal('hide');
});

btnMangIconClose.addEventListener('click', () => {
    $('#thongTinBaiThiModal').modal('hide');
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
                        <td>${item.soCauDung + item.soCauSai + item.soCauTrong}</td>
                        <td>${item.soCauDung}</td>
                        <td>${item.soCauSai}</td>
                        <td>${item.timeComplete}</td>
                        <td>${item.score}</td>
                        <td>${item.ketQua}</td>
                        <td>
                            <button class="btn btn-primary">Xem</button>
                            <button class="btn btn-danger">Xóa</button>
                        </td>
                    </tr>`;
        });

        $('#thongTinBaiThiModal .modal-body .table tbody').html(html);
    } else {
        alert("Tài khoản này chưa làm bài thi nào");
    }
}