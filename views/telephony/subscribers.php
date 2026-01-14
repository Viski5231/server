<?php /** @var bool|null $success */ ?>
<?php /** @var string|null $message */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Division[] $divisions */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Subscriber[] $subscribers */ ?>

<div class="container">
    <h1>Абоненты</h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-info">Абонент добавлен.</div>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="content">
        <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">

        <div class="form-group">
            <label for="lastname">Фамилия:</label>
            <input type="text" id="lastname" name="lastname" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="firstname">Имя:</label>
            <input type="text" id="firstname" name="firstname" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="patronymic">Отчество:</label>
            <input type="text" id="patronymic" name="patronymic" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="birthdate">Дата рождения:</label>
            <input type="date" id="birthdate" name="birthdate" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="division_id">Подразделение:</label>
            <select id="division_id" name="division_id" class="drop-list" required>
                <option value="" selected disabled>Выберите подразделение</option>
                <?php foreach ($divisions as $d): ?>
                    <option value="<?= (int)$d->id ?>"><?= htmlspecialchars(($d->name ?? '') . ' — ' . ($d->type ?? '')) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>

    <table class="table">
        <tbody>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Дата рождения</th>
            <th>Подразделение</th>
        </tr>
        <?php foreach ($subscribers as $s): ?>
            <tr>
                <td><?= (int)$s->id ?></td>
                <td><?= htmlspecialchars(trim(($s->lastname ?? '') . ' ' . ($s->firstname ?? '') . ' ' . ($s->patronymic ?? ''))) ?></td>
                <td><?= htmlspecialchars((string)($s->birthdate ?? '')) ?></td>
                <td><?= htmlspecialchars($s->division->name ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

