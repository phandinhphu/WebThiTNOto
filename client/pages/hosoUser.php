<div class="col c-9">
    <div class="card">
        <div class="card-header">
            <h3>Hồ sơ của tôi</h3>
            <div class="alert" role="alert">
                <strong></strong>
            </div>
        </div>
        <div class="card-body">
            <?php $user = getRow('SELECT * FROM users where id = :id', ['id' => $_SESSION['user']['id']]) ?>
            <div id="form-profile">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= $_SESSION['user']['userName'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= $user['email'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?= $user['phone'] ?>" required>
                </div>
                <button type="submit" class="btn btn-primary js-save-info">Save</button>
            </div>
        </div>
    </div>
</div>