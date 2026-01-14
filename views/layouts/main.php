<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Внутренняя телефония</title>
    <link rel="stylesheet" href="<?= app()->route->getUrl('/css/style.css') ?>">
</head>
<body>
<header>
    <?php if (app()->auth::check()): ?>
        <?php 
        $userRole = app()->auth::user()->role ?? '';
        // Получаем текущий URI
        $currentUri = $_SERVER['REQUEST_URI'];
        // Убираем query string
        if (($pos = strpos($currentUri, '?')) !== false) {
            $currentUri = substr($currentUri, 0, $pos);
        }
        // Убираем префикс если есть
        $prefix = app()->route->getUrl('');
        if ($prefix && strpos($currentUri, $prefix) === 0) {
            $currentUri = substr($currentUri, strlen($prefix));
        }
        if ($currentUri === '' || $currentUri === '/') {
            $currentUri = '/';
        }
        $currentPath = rtrim($currentUri, '/');
        
        // Функция для проверки активной ссылки
        $isActive = function($route) use ($currentPath) {
            $route = rtrim($route, '/');
            if ($route === '' || $route === '/') {
                return $currentPath === '' || $currentPath === '/';
            }
            return $currentPath === $route || strpos($currentPath, $route . '/') === 0;
        };
        ?>
        <nav>
            <a href="<?= app()->route->getUrl('/subscribers') ?>" <?= $isActive('/subscribers') ? 'class="active"' : '' ?>>Абоненты</a>
            <a href="<?= app()->route->getUrl('/phones') ?>" <?= $isActive('/phones') ? 'class="active"' : '' ?>>Телефоны</a>
            <a href="<?= app()->route->getUrl('/premises') ?>" <?= $isActive('/premises') ? 'class="active"' : '' ?>>Помещения</a>
            <a href="<?= app()->route->getUrl('/divisions') ?>" <?= $isActive('/divisions') ? 'class="active"' : '' ?>>Подразделения</a>
            <a href="<?= app()->route->getUrl('/assign-phone') ?>" <?= $isActive('/assign-phone') ? 'class="active"' : '' ?>>Привязка номера</a>
            <a href="<?= app()->route->getUrl('/reports') ?>" <?= $isActive('/reports') ? 'class="active"' : '' ?>>Отчёты</a>

            <?php if ($userRole === 'admin'): ?>
                <a href="<?= app()->route->getUrl('/admin/sysadmins') ?>" <?= $isActive('/admin/sysadmins') ? 'class="active"' : '' ?>>Сисадмины</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>

    <div>
        <h2>Внутренняя телефония</h2>
        <nav>
            <a href="<?= app()->route->getUrl('/') ?>">Главная</a>
            <?php if (!app()->auth::check()): ?>
                <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <?php else: ?>
                <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main>
    <?= $content ?? '' ?>
</main>
</body>
</html>