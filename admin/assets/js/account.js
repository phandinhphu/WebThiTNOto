const btnEditUsers = document.querySelectorAll('.js-edit-user');
const btnDeleteUsers = document.querySelectorAll('.js-delete-user');
const btnCloseIcon = document.getElementById('edit-user-icon-close');
const btnClose = document.getElementById('js-edit-user-close');
const btnUpdate = document.getElementById('js-edit-user-save');
const btnAdd = document.getElementById('js-add-user-save');
const btnRpw = document.querySelectorAll('.js-rpw-user');
var id;


document.getElementById('add-user').addEventListener('click', () => {
    $('#addUserModal').modal('show');
});

document.getElementById('js-rpw-user-close').addEventListener('click', () => {
    $('#rpwUserModal').modal('hide');
});

document.getElementById('rpw-user-icon-close').addEventListener('click', () => {
    $('#rpwUserModal').modal('hide');
});

document.getElementById('js-add-user-close').addEventListener('click', () => {
    $('#addUserModal').modal('hide');
});

document.getElementById('add-user-icon-close').addEventListener('click', () => {
    $('#addUserModal').modal('hide');
});

btnClose.addEventListener('click', () => {
    $('#editUserModal').modal('hide');
});

btnCloseIcon.addEventListener('click', () => {
    $('#editUserModal').modal('hide');
});

btnEditUsers.forEach(item => {
    item.addEventListener('click', async () => {
        $('#editUserModal').modal('show');
        id = item.getAttribute('value');
        const response = await fetch(`http://localhost/WebThiTN-Oto/api/user/getUser.php?id=${id}`);
        const { data: user} = await response.json();
        $('#userName').val(user.userName);
        $('#email').val(user.email);
        $('#phone').val(user.phone);
        user.status == 1 ? $('#status').val('1') : $('#status').val('0');        
    });
});

btnDeleteUsers.forEach(item => {
    item.addEventListener('click', async () => {
        let confirm = window.confirm('Bạn có chắc chắn muốn xóa?');
        if(!confirm) return;

        const id = item.getAttribute('value');
        const data = {
            id
        }
        const response = await fetch('http://localhost/WebThiTN-Oto/admin/account/delete-account.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const res = await response.json();
        if(res.status === 200) {
            alert(res.message);
            location.reload();
        } else {
            alert('Xóa thất bại');
        }
    });
});

btnUpdate.addEventListener('click', async () => {
    const userName = $('#userName').val();
    const email = $('#email').val();
    const phone = $('#phone').val();
    const status = $('#status').val();
    const data = {
        id,
        userName,
        email,
        phone,
        status
    }
    const response = await fetch('http://localhost/WebThiTN-Oto/admin/account/edit-account.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    const res = await response.json();
    if(res.status === 200) {
        alert(res.message);
        location.reload();
    } else {
        alert('Cập nhật thất bại');
    }
});

btnAdd.addEventListener('click', async () => {
    const userName = $('#addUserName').val();
    const email = $('#addEmail').val();
    const phone = $('#addPhone').val();
    const password = $('#addPassword').val();
    const status = $('#addStatus').val();

    if (password.length < 6) {
        alert('Mật khẩu phải có ít nhất 6 ký tự');
        return;
    }

    let regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!regexEmail.test(email)) {
        alert('Email không hợp lệ');
        return;
    }

    let regexPhone = /^(0)[0-9]{9}$/;
    if (!regexPhone.test(phone)) {
        alert('Số điện thoại không hợp lệ');
        return;
    }

    const data = {
        userName,
        email,
        phone,
        password,
        status
    }

    const response = await fetch('http://localhost/WebThiTN-Oto/admin/account/add-account.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    const res = await response.json();
    if(res.status === 200) {
        alert(res.message);
        location.reload();
    } else {
        alert('Thêm thất bại');
    }
});



btnRpw.forEach(item => {
    item.addEventListener('click', () => {
        $('#rpwUserModal').modal('show');
        const id = item.getAttribute('value');

        document.getElementById('js-rpw-user-save').addEventListener('click', function() {
            handleSendMail(id);
        });
    });
});

async function handleSendMail(id) {
    const subject = $('#subject').val();
    const content = $('#content').val();
    const data = {
        id,
        subject,
        content
    }
    const response = await fetch('http://localhost/WebThiTN-Oto/admin/account/send-mail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const res = await response.json();
    if(res.status === 200) {
        alert(res.message);
        location.reload();
    } else {
        alert('Gửi mail thất bại');
    }
}