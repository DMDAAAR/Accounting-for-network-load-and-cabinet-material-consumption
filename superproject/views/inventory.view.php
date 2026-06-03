<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оборудование (MVP)</title>
</head>
<body>
<h1>Список сетевых точек</h1>
<?php if (empty($points)): ?>
    <p>Данные не получены.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Метка</th>
            <th>Тип</th>
            <th>Статус</th>
            <th>Локация</th>
            <th>Конечная локация</th>
            <th>Дата проверки</th>
        </tr>
        <?php foreach ($points as $point): ?>
            <tr>
                <td><?= htmlspecialchars($point['id']) ?></td>
                <td><?= htmlspecialchars($point['label']) ?></td>
                <td><?= htmlspecialchars($point['type']) ?></td>
                <td><?= htmlspecialchars($point['status']) ?></td>
                <td><?= htmlspecialchars($point['location_name'] ?? '—') ?></td>
                <td><?= htmlspecialchars($point['location_end_name'] ?? '—') ?></td>
                <td><?= htmlspecialchars($point['last_check'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</body>
</html>
