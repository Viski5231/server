<?php /** @var bool|null $success */ ?>
<?php /** @var string|null $message */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Division[] $divisions */ ?>

<div class="container">
    <h1>Подразделения</h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-info">Подразделение добавлено.</div>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="content">
        <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">

        <div class="form-group">
            <label for="name">Название:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="type">Вид подразделения:</label>
            <input type="text" id="type" name="type" class="form-control" required placeholder="Отдел / Управление / ...">
        </div>

        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>

    <table class="table">
        <tbody>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Вид</th>
        </tr>
        <?php foreach ($divisions as $d): ?>
            <tr>
                <td><?= (int)$d->id ?></td>
                <td><?= htmlspecialchars($d->name ?? '') ?></td>
                <td><?= htmlspecialchars($d->type ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

