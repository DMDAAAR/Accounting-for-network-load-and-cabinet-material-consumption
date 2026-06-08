<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отчеты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include __DIR__ . '/components/header.view.php'; ?>

<div class="container mt-4">
    <div class="print-header mb-4">
        <h2>Отчет по дефектам сетевой инфраструктуры</h2>
        <p>Кабинет 319Б — Отчет сформирован: <?= date('d.m.Y H:i') ?></p>
        <hr>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Отчеты и экспорт</h2>
        
        <div class="btn-actions d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark">
                Печать
            </button>
            <?php
            $csvParams = $_GET;
            $csvParams['export'] = 'csv';
            $csvUrl = 'report.controller.php?' . http_build_query($csvParams);
            ?>
            <a href="<?= $csvUrl ?>" class="btn btn-success">
                Экспорт CSV
            </a>
        </div>
    </div>

    <div class="card filter-card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Фильтры отчета</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="report.controller.php" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Дата с</label>
                    <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars($date_from) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Дата по</label>
                    <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars($date_to) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Раздел</label>
                    <select name="category" class="form-select">
                        <option value="all">Все разделы</option>
                        <?php foreach ($categoriesList as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Тип точки</label>
                    <select name="point_type" class="form-select">
                        <option value="all" <?= $point_type === 'all' ? 'selected' : '' ?>>Все типы</option>
                        <option value="socket" <?= $point_type === 'socket' ? 'selected' : '' ?>>Розетка</option>
                        <option value="switch" <?= $point_type === 'switch' ? 'selected' : '' ?>>Коммутатор</option>
                        <option value="cable_run" <?= $point_type === 'cable_run' ? 'selected' : '' ?>>Трасса кабеля</option>
                        <option value="patch_cord" <?= $point_type === 'patch_cord' ? 'selected' : '' ?>>Патч-корд</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Статус</label>
                    <select name="status" class="form-select">
                        <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>Все статусы</option>
                        <option value="open" <?= $status === 'open' ? 'selected' : '' ?>>Открыт</option>
                        <option value="in_progress" <?= $status === 'in_progress' ? 'selected' : '' ?>>В работе</option>
                        <option value="closed" <?= $status === 'closed' ? 'selected' : '' ?>>Закрыт</option>
                    </select>
                </div>
                <div class="col-12 text-end">
                    <a href="report.controller.php" class="btn btn-secondary me-2">Сбросить</a>
                    <button type="submit" class="btn btn-primary">Сформировать</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-body p-0">
            <?php if (!empty($records)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Название дефекта</th>
                                <th>Раздел</th>
                                <th>Критичность</th>
                                <th>Сетевая точка</th>
                                <th>Тип точки</th>
                                <th>Локация</th>
                                <th>Статус</th>
                                <th>Дата создания</th>
                                <th>Создал</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $row): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($row['title']) ?></strong></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['category']) ?></span></td>
                                    <td>
                                        <?php if ($row['severity'] === 'high'): ?>
                                            <span class="text-danger fw-bold">Высокая</span>
                                        <?php elseif ($row['severity'] === 'medium'): ?>
                                            <span class="text-warning fw-bold">Средняя</span>
                                        <?php else: ?>
                                            <span class="text-success">Низкая</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['point_label'] ?? '—') ?></td>
                                    <td><?= htmlspecialchars($row['point_type'] ?? '—') ?></td>
                                    <td><?= htmlspecialchars($row['location_name'] ?? '—') ?></td>
                                    <td>
                                        <?php if ($row['status'] === 'open'): ?>
                                            <span class="badge bg-danger">Открыт</span>
                                        <?php elseif ($row['status'] === 'in_progress'): ?>
                                            <span class="badge bg-warning text-dark">В работе</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Закрыт</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d.m.Y H:i', strtotime($row['created_at'])) ?></td>
                                    <td><?= htmlspecialchars($row['creator_login'] ?? '—') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-4 text-center text-muted">
                    Нет записей по выбранным фильтрам
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/components/footer.view.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>