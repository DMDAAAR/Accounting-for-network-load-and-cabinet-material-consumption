<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Журнал действий</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { background: #333; color: white; padding: 10px; margin-bottom: 20px; }
        .header a { color: white; text-decoration: none; margin-right: 15px; }
    </style>
</head>
<body>

<div class="header">
    <a href="dashboard.controller.php">Главная</a>
    <a href="defects.controller.php">Поломки</a>
    <a href="inventory.controller.php">Оборудование</a>
    <a href="logs.controller.php" style="font-weight: bold;">Логи</a>
    <a href="logout.controller.php">Выход</a>
    <span style="float: right;">Администратор</span>
</div>

<h2>Журнал действий</h2>

<?php if (empty($logs)): ?>
    <p>Журнал действий пуст.</p>
<?php else: ?>
    <table>
        <thead>
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
                    <td><?= $log['name'] ?? 'Система' ?></td>
                    <td><?= htmlspecialchars($log['action']) ?></td>
                    <td><?= $log['target_table'] ?: '—' ?></td>
                    <td><?= $log['target_id'] ?: '—' ?></td>
                    <td><?= date('d.m.Y H:i:s', strtotime($log['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
