<?php
/** @var \Illuminate\Support\Collection|\Model\Division[] $divisions */
/** @var \Illuminate\Support\Collection|\Model\Subscriber[] $subscribers */
/** @var int|null $divisionId */
/** @var int|null $subscriberId */
/** @var array|\Illuminate\Support\Collection $numbersByDivision */
/** @var array|\Illuminate\Support\Collection $numbersOfSubscriber */
/** @var array|\Illuminate\Support\Collection $countByDivision */
/** @var array|\Illuminate\Support\Collection $countByPremise */
?>

<div class="container">
    <h1>Отчёты</h1>

    <div class="content" style="max-width: 1200px;">
        <div style="display:flex; gap: 30px; flex-wrap:wrap; justify-content:center; width:100%;">
            <form method="get" action="<?= app()->route->getUrl('/reports') ?>" style="padding:0; margin:0;">
                <div class="form-group">
                    <label for="division_id">Номера абонентов по подразделению</label>
                    <select id="division_id" name="division_id" class="drop-list">
                        <option value="">— выбрать —</option>
                        <?php foreach ($divisions as $d): ?>
                            <option value="<?= (int)$d->id ?>" <?= ($divisionId === (int)$d->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars(($d->name ?? '') . ' — ' . ($d->type ?? '')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Показать</button>
            </form>

            <form method="get" action="<?= app()->route->getUrl('/reports') ?>" style="padding:0; margin:0;">
                <div class="form-group">
                    <label for="subscriber_id">Все номера абонента</label>
                    <select id="subscriber_id" name="subscriber_id" class="drop-list">
                        <option value="">— выбрать —</option>
                        <?php foreach ($subscribers as $s): ?>
                            <option value="<?= (int)$s->id ?>" <?= ($subscriberId === (int)$s->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars(trim(($s->lastname ?? '') . ' ' . ($s->firstname ?? '') . ' ' . ($s->patronymic ?? ''))) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Показать</button>
            </form>
        </div>
    </div>

    <?php if (!empty($divisionId)): ?>
        <h3>Номера абонентов выбранного подразделения</h3>
        <table class="table">
            <tbody>
            <tr>
                <th>Абонент</th>
                <th>Номер</th>
            </tr>
            <?php foreach ($numbersByDivision as $r): ?>
                <tr>
                    <td><?= htmlspecialchars(trim(($r->lastname ?? '') . ' ' . ($r->firstname ?? '') . ' ' . ($r->patronymic ?? ''))) ?></td>
                    <td><?= htmlspecialchars((string)($r->number ?? '—')) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (!empty($subscriberId)): ?>
        <h3>Все номера выбранного абонента</h3>
        <table class="table">
            <tbody>
            <tr>
                <th>Номер</th>
                <th>Помещение</th>
            </tr>
            <?php foreach ($numbersOfSubscriber as $r): ?>
                <tr>
                    <td><?= htmlspecialchars((string)($r->number ?? '—')) ?></td>
                    <td><?= htmlspecialchars(trim(($r->premise_name ?? '') . ' ' . ($r->premise_type ? '(' . $r->premise_type . ')' : ''))) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h3>Количество абонентов по подразделениям</h3>
    <table class="table">
        <tbody>
        <tr>
            <th>Подразделение</th>
            <th>Вид</th>
            <th>Абонентов</th>
        </tr>
        <?php foreach ($countByDivision as $r): ?>
            <tr>
                <td><?= htmlspecialchars((string)($r->name ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($r->type ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($r->subscribers_count ?? '0')) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Количество абонентов по помещениям (по привязкам номеров)</h3>
    <table class="table">
        <tbody>
        <tr>
            <th>Помещение</th>
            <th>Вид</th>
            <th>Абонентов</th>
        </tr>
        <?php foreach ($countByPremise as $r): ?>
            <tr>
                <td><?= htmlspecialchars((string)($r->name ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($r->type ?? '')) ?></td>
                <td><?= htmlspecialchars((string)($r->subscribers_count ?? '0')) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

