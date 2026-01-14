<?php
/** @var int $totalSubscribers */
/** @var int $totalPhones */
/** @var int $totalDivisions */
/** @var int $totalPremises */
?>

<div class="container">
    <h1>Панель учета внутренней телефонии</h1>

    <div class="list">
        <p><strong>Абонентов:</strong> <?= (int)$totalSubscribers ?></p>
        <p><strong>Телефонов:</strong> <?= (int)$totalPhones ?></p>
        <p><strong>Подразделений:</strong> <?= (int)$totalDivisions ?></p>
        <p><strong>Помещений:</strong> <?= (int)$totalPremises ?></p>
    </div>

    <?php if (!app()->auth::check()): ?>
        <div class="alert alert-info" style="max-width: 900px;">
            Для работы войдите под учетной записью.
        </div>
    <?php endif; ?>
</div>

