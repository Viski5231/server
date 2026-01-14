<?php /** @var bool|null $success */ ?>
<?php /** @var string|null $message */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\User[] $sysadmins */ ?>

<div class="container">
    <h1>Системные администраторы</h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-info">Системный администратор успешно добавлен.</div>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <h3>Добавить нового сисадмина</h3>
    <form method="post" class="content">
        <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">

        <div class="form-group">
            <label for="lastname">Фамилия:</label>
            <input type="text" id="lastname" name="lastname" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>

    <h3>Список</h3>
    <table class="table">
        <tbody>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Логин</th>
            <th>Роль</th>
        </tr>
        <?php foreach ($sysadmins as $u): ?>
            <tr>
                <td><?= (int)$u->id ?></td>
                <td><?= htmlspecialchars(trim(($u->lastname ?? '') . ' ' . ($u->name ?? ''))) ?></td>
                <td><?= htmlspecialchars($u->login ?? '') ?></td>
                <td><?= htmlspecialchars($u->role ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

