<?php /** @var bool|null $success */ ?>
<?php /** @var string|null $message */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Premise[] $premises */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Phone[] $phones */ ?>

<div class="container">
    <h1>Телефоны</h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-info">Телефон добавлен.</div>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="content">
        <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">

        <div class="form-group">
            <label for="number">Номер телефона:</label>
            <input type="text" id="number" name="number" class="form-control" required placeholder="101 / 8(495)... / ...">
        </div>

        <div class="form-group">
            <label for="premise_id">Помещение:</label>
            <select id="premise_id" name="premise_id" class="drop-list" required>
                <option value="" selected disabled>Выберите помещение</option>
                <?php foreach ($premises as $p): ?>
                    <option value="<?= (int)$p->id ?>">
                        <?= htmlspecialchars(($p->name ?? '') . ' — ' . ($p->type ?? '') . ' / ' . ($p->division->name ?? '')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>

    <table class="table">
        <tbody>
        <tr>
            <th>ID</th>
            <th>Номер</th>
            <th>Помещение</th>
            <th>Подразделение</th>
        </tr>
        <?php foreach ($phones as $ph): ?>
            <tr>
                <td><?= (int)$ph->id ?></td>
                <td><?= htmlspecialchars($ph->number ?? '') ?></td>
                <td><?= htmlspecialchars($ph->premise->name ?? '') ?></td>
                <td><?= htmlspecialchars($ph->premise->division->name ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

