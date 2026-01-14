<?php /** @var bool|null $success */ ?>
<?php /** @var string|null $message */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Division[] $divisions */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Premise[] $premises */ ?>

<div class="container">
    <h1>Помещения</h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-info">Помещение добавлено.</div>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="content">
        <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">

        <div class="form-group">
            <label for="name">Название/номер:</label>
            <input type="text" id="name" name="name" class="form-control" required placeholder="101 / Каб. 12 / ...">
        </div>

        <div class="form-group">
            <label for="type">Вид помещения:</label>
            <input type="text" id="type" name="type" class="form-control" required placeholder="кабинет / аудитория / ...">
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
            <th>Помещение</th>
            <th>Вид</th>
            <th>Подразделение</th>
        </tr>
        <?php foreach ($premises as $p): ?>
            <tr>
                <td><?= (int)$p->id ?></td>
                <td><?= htmlspecialchars($p->name ?? '') ?></td>
                <td><?= htmlspecialchars($p->type ?? '') ?></td>
                <td><?= htmlspecialchars($p->division->name ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

