<?php /** @var bool|null $success */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Subscriber[] $subscribers */ ?>
<?php /** @var \Illuminate\Support\Collection|\Model\Phone[] $phones */ ?>
<?php /** @var array|\Illuminate\Support\Collection $assignments */ ?>

<div class="container">
    <h1>Привязка абонента к номеру</h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-info">Привязка сохранена.</div>
    <?php endif; ?>

    <form method="post" class="content">
        <input type="hidden" name="csrf_token" value="<?= \Src\Session::get('csrf_token') ?>">

        <div class="form-group">
            <label for="subscriber_id">Абонент:</label>
            <select id="subscriber_id" name="subscriber_id" class="drop-list" required>
                <option value="" selected disabled>Выберите абонента</option>
                <?php foreach ($subscribers as $s): ?>
                    <option value="<?= (int)$s->id ?>">
                        <?= htmlspecialchars(trim(($s->lastname ?? '') . ' ' . ($s->firstname ?? '') . ' ' . ($s->patronymic ?? ''))) ?>
                        (<?= htmlspecialchars($s->division->name ?? '') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="phone_id">Номер:</label>
            <select id="phone_id" name="phone_id" class="drop-list" required>
                <option value="" selected disabled>Выберите номер</option>
                <?php foreach ($phones as $p): ?>
                    <option value="<?= (int)$p->id ?>">
                        <?= htmlspecialchars($p->number ?? '') ?>
                        — <?= htmlspecialchars(($p->premise->name ?? '') . ' / ' . ($p->premise->division->name ?? '')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Привязать</button>
    </form>

    <h3>Текущие привязки</h3>
    <table class="table">
        <tbody>
        <tr>
            <th>Дата</th>
            <th>Абонент</th>
            <th>Подразделение</th>
            <th>Номер</th>
            <th>Помещение</th>
        </tr>
        <?php foreach ($assignments as $a): ?>
            <tr>
                <td><?= htmlspecialchars((string)($a->assigned_at ?? '')) ?></td>
                <td><?= htmlspecialchars(trim(($a->lastname ?? '') . ' ' . ($a->firstname ?? '') . ' ' . ($a->patronymic ?? ''))) ?></td>
                <td><?= htmlspecialchars((string)($a->division_name ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($a->number ?? '')) ?></td>
                <td><?= htmlspecialchars(trim(($a->premise_name ?? '') . ' ' . ($a->premise_type ? '(' . $a->premise_type . ')' : ''))) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

