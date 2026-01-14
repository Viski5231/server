<?php /** @var string $message */ ?>
<div class="container">
    <h2>Авторизация</h2>
    <h3><?= $message ?? ''; ?></h3>
    <form method="post" class="content">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="form-group">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</div>