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
    <h2 class="mb-4"><i class="bi bi-graph-up"></i> Статистика кабинета 319Б</h2>

    <!-- Карточки показателей -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card text-white bg-primary h-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Всего ПК</h6>
                            <h2 class="display-4 mb-0"><?= $totalComputers ?></h2>
                        </div>
                        <i class="bi bi-pc-display display-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success h-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Активные точки</h6>
                            <h2 class="display-4 mb-0"><?= $networkStats['active'] ?></h2>
                        </div>
                        <i class="bi bi-check-circle-fill display-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger h-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Точки с дефектом</h6>
                            <h2 class="display-4 mb-0"><?= $networkStats['defect'] ?></h2>
                        </div>
                        <i class="bi bi-exclamation-triangle-fill display-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary h-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Списано точек</h6>
                            <h2 class="display-4 mb-0"><?= $networkStats['decommissioned'] ?></h2>
                        </div>
                        <i class="bi bi-slash-circle display-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Круговые диаграммы -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Сетевые точки по статусам</h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($totalNetwork > 0): ?>
                        <div class="donut-chart" style="width: 220px; height: 220px; margin: 0 auto 20px; border-radius: 50%; background: conic-gradient(
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
            <div class="card shadow h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Материалы на складе</h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($totalMaterial > 0): ?>
                        <div class="donut-chart" style="width: 220px; height: 220px; margin: 0 auto 20px; border-radius: 50%; background: conic-gradient(
                        <?php
                        $parts = [];
                        foreach ($materialAngles as $item) {
                            $parts[] = "{$item['color']} {$item['start']}deg {$item['end']}deg";
                        }
                        echo implode(', ', $parts);
                        ?>
                                );"></div>
                    <?php else: ?>
                        <div class="alert alert-info">Нет данных по материалам</div>
                    <?php endif; ?>
                    <div class="row mt-3">
                        <?php foreach ($materialAngles as $item): ?>
                            <div class="col-4">
                                <span class="badge" style="background-color: <?= $item['color'] ?>; width: 20px; height: 20px; display: inline-block; vertical-align: middle;"></span>
                                <span><?= $item['label'] ?>: <?= number_format($item['value'], 2) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="alert alert-warning mt-3 small">
                        <i class="bi bi-info-circle"></i> Единицы измерения разные (метры / штуки). Диаграмма показывает долю от общего числа единиц.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Панель коммутатора -->
    <div class="card shadow mb-5">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-hdd-stack"></i> Коммутатор — 17 портов</h5>
        </div>
        <div class="card-body">
            <div class="ports-grid">
                <?php for ($i = 1; $i <= 17; $i++):
                    $port = $switchPorts[$i];
                    $colorClass = '';
                    $title = '';
                    switch ($port['color']) {
                        case 'green':
                            $colorClass = 'port-green';
                            $title = 'Порт ' . $i . ' — левая стена (активен)';
                            break;
                        case 'blue':
                            $colorClass = 'port-blue';
                            $title = 'Порт ' . $i . ' — правая стена (активен)';
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
            <div class="legend-switch mt-4 d-flex justify-content-center gap-4">
                <span><i class="bi bi-circle-fill" style="color: #28a745;"></i> Левая стена (1-8)</span>
                <span><i class="bi bi-circle-fill" style="color: #0d6efd;"></i> Правая стена (9-17)</span>
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