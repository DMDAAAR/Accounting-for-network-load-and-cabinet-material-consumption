<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Журнал действий</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<?php
include __DIR__ . '/components/header.view.php';
?>

<div class="container mt-4">
    <h2>Журнал действий</h2>

    <?php if (empty($logs)): ?>
        <div class="alert alert-info">Журнал действий пуст.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Действие</th>
                    <th>Таблица</th>
                    <th>ID записи</th>
                    <th>Дата</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><?= htmlspecialchars($log['name'] ?? 'Система') ?></td>
                        <td><?= htmlspecialchars($log['action']) ?></td>
                        <td><?= htmlspecialchars($log['target_table'] ?: '—') ?></td>
                        <td><?= $log['target_id'] ?: '—' ?></td>
                        <td><?= date('d.m.Y H:i:s', strtotime($log['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
include __DIR__ . '/components/footer.view.php';
?>
</body>
</html>