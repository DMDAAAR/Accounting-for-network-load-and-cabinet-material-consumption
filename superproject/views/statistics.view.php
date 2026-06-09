<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика ЛВС</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/statistics.css">
</head>
<body>
<?php include __DIR__ . '/components/header.view.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-graph-up"></i> Статистика расхода материалов</h2>
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Кабель</h6>
                            <h2 class="display-4 mb-0"><?= number_format($materialsUsage['cable']['used'], 2) ?></h2>
                            <small class="text-muted"><?= $materialsUsage['cable']['unit'] ?></small>
                        </div>
                        <i class="bi bi-diagram-3 fs-1 text-info opacity-50"></i>
                    </div>
                    <div class="mt-3 small text-muted">
                        <i class="bi bi-box"></i> Остаток: <?= number_format($materialsRemaining['cable'], 2) ?> м
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Коннекторы RJ45</h6>
                            <h2 class="display-4 mb-0"><?= number_format($materialsUsage['connector']['used'], 0) ?></h2>
                            <small class="text-muted"><?= $materialsUsage['connector']['unit'] ?></small>
                        </div>
                        <i class="bi bi-plug fs-1 text-warning opacity-50"></i>
                    </div>
                    <div class="mt-3 small text-muted">
                        <i class="bi bi-box"></i> Остаток: <?= number_format($materialsRemaining['connector'], 0) ?> шт
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Розетки RJ45</h6>
                            <h2 class="display-4 mb-0"><?= number_format($materialsUsage['socket']['used'], 0) ?></h2>
                            <small class="text-muted"><?= $materialsUsage['socket']['unit'] ?></small>
                        </div>
                        <i class="bi bi-grid-3x3-gap-fill fs-1 text-primary opacity-50"></i>
                    </div>
                    <div class="mt-3 small text-muted">
                        <i class="bi bi-box"></i> Остаток: <?= number_format($materialsRemaining['socket'], 0) ?> шт
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Операций расхода</h6>
                            <h2 class="display-4 mb-0"><?= number_format($materialsUsage['operations']['used'], 0) ?></h2>
                            <small class="text-muted"><?= $materialsUsage['operations']['unit'] ?></small>
                        </div>
                        <i class="bi bi-arrow-repeat fs-1 text-secondary opacity-50"></i>
                    </div>
                    <div class="mt-3 small text-muted">
                        <i class="bi bi-calendar"></i> За всё время
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Круговые диаграммы -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Сетевые точки по статусам</h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($totalNetwork > 0): ?>
                        <div style="width: 220px; height: 220px; margin: 0 auto 20px; border-radius: 50%; background: conic-gradient(
                        <?php
                        $parts = [];
                        foreach ($networkAngles as $item) {
                            $parts[] = "{$item['color']} {$item['start']}deg {$item['end']}deg";
                        }
                        echo implode(', ', $parts);
                        ?>
                                );"></div>
                    <?php else: ?>
                        <div class="alert alert-info">Нет данных по сетевым точкам</div>
                    <?php endif; ?>
                    <div class="row mt-3">
                        <?php foreach ($networkAngles as $item): ?>
                            <div class="col-4">
                                <span class="badge" style="background-color: <?= $item['color'] ?>; width: 20px; height: 20px; display: inline-block; vertical-align: middle;"></span>
                                <span><?= $item['label'] ?>: <?= $item['value'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Остатки материалов на складе</h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($totalRemaining > 0): ?>
                        <div style="width: 220px; height: 220px; margin: 0 auto 20px; border-radius: 50%; background: conic-gradient(
                        <?php
                        $parts = [];
                        foreach ($remainingAngles as $item) {
                            $parts[] = "{$item['color']} {$item['start']}deg {$item['end']}deg";
                        }
                        echo implode(', ', $parts);
                        ?>
                                );"></div>
                    <?php else: ?>
                        <div class="alert alert-info">Нет данных по остаткам материалов</div>
                    <?php endif; ?>
                    <div class="row mt-3">
                        <?php foreach ($remainingAngles as $item): ?>
                            <div class="col-4">
                                <span class="badge" style="background-color: <?= $item['color'] ?>; width: 20px; height: 20px; display: inline-block; vertical-align: middle;"></span>
                                <span><?= $item['label'] ?>: <?= number_format($item['value'], 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="alert alert-info mt-3 small">
                        <i class="bi bi-info-circle"></i> Текущие остатки материалов на складе
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Панель коммутатора - 24 порта -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-hdd-stack"></i> Коммутатор — 24 порта</h5>
        </div>
        <div class="card-body">
            <div class="ports-grid" style="grid-template-columns: repeat(12, 1fr); gap: 12px;">
                <?php for ($i = 1; $i <= 24; $i++):
                    $color = 'gray';

                    if (isset($switchPorts[$i])) {
                        $color = $switchPorts[$i]['color'];
                    } else {
                        if ($i <= 12) {
                            $color = 'green';
                        } else {
                            $color = 'blue';
                        }
                    }

                    $colorClass = '';
                    $title = '';
                    switch ($color) {
                        case 'green':
                            $colorClass = 'port-green';
                            $title = 'Порт ' . $i . ' — левая сторона (активен)';
                            break;
                        case 'blue':
                            $colorClass = 'port-blue';
                            $title = 'Порт ' . $i . ' — правая сторона (активен)';
                            break;
                        case 'red':
                            $colorClass = 'port-red';
                            $title = 'Порт ' . $i . ' — дефект (требуется ремонт)';
                            break;
                        default:
                            $colorClass = 'port-gray';
                            $title = 'Порт ' . $i . ' — свободен';
                    }
                    ?>
                    <div class="port <?= $colorClass ?>" title="<?= $title ?>">
                        <span class="port-number"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></span>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="legend-switch mt-4 d-flex justify-content-center gap-4 flex-wrap">
                <span><i class="bi bi-circle-fill" style="color: #28a745;"></i> Левая сторона (1-12)</span>
                <span><i class="bi bi-circle-fill" style="color: #0d6efd;"></i> Правая сторона (13-24)</span>
                <span><i class="bi bi-circle-fill" style="color: #dc3545;"></i> Дефект</span>
                <span><i class="bi bi-circle-fill" style="color: #adb5bd;"></i> Свободен</span>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/components/footer.view.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>