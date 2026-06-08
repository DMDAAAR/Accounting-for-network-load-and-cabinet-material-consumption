<?php include __DIR__ . '/components/header.view.php'; ?>
<style>
    /* Основные стили для схемы кабинета */

    .cabinet-title {
        text-align: center;
        color: #2c5e2c;
        margin-bottom: 5px;
        font-size: 28px;
    }

    .cabinet-subtitle {
        text-align: center;
        color: #6c757d;
        margin-bottom: 25px;
        font-size: 14px;
    }

    /* Легенда */
    .legend {
        display: flex;
        gap: 25px;
        justify-content: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }


    .legend-color {
        width: 18px;
        height: 18px;
        border-radius: 4px;
    }

    .legend-color.ok { background: #28a745; }
    .legend-color.defect { background: #dc3545; }
    .legend-color.empty { background: #6c757d; }

    /* Сетка рабочих мест */
    .workstations-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        padding: 10px;
    }

    /* Карточка компьютера */
    .workstation-card {
        background: white;
        border-radius: 16px;
        padding: 20px 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-top: 4px solid;
    }

    .workstation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* Статус: исправно */
    .status-ok {
        border-top-color: #28a745;
        background: linear-gradient(135deg, #ffffff 0%, #f0fff0 100%);
    }

    /* Статус: есть дефекты */
    .status-defect {
        border-top-color: #dc3545;
        background: linear-gradient(135deg, #ffffff 0%, #fff0f0 100%);
    }

    /* Статус: нет точки */
    .status-empty {
        border-top-color: #6c757d;
        background: #f8f9fa;
        opacity: 0.8;
    }

    .pc-number {
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin: 10px 0;
    }

    .status-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .status-text {
        font-size: 13px;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 8px;
    }

    .status-text.ok {
        color: #28a745;
        background: #e8f5e9;
    }

    .status-text.empty {
        color: #6c757d;
        background: #e9ecef;
    }

    /* Статистика */
    .stats-row {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 10px 25px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .stat-number {
        font-size: 28px;
        font-weight: bold;
    }

    .stat-label {
        font-size: 12px;
        color: #6c757d;
    }

</style>
<div class="container mt-4">
    <div class="cabinet-container">
        <h1 class="cabinet-title">
            <i class="bi bi-building"></i> Кабинет 319Б
        </h1>
        <p class="cabinet-subtitle">
            <i class="bi bi-grid-3x3-gap-fill"></i> План расположения рабочих мест
        </p>

        <!-- Легенда -->
        <div class="legend">
            <div class="legend-item">
                <div class="legend-color ok"></div>
                <span><i class="bi bi-check-circle"></i> Исправно</span>
            </div>
            <div class="legend-item">
                <div class="legend-color defect"></div>
                <span><i class="bi bi-exclamation-triangle"></i> Есть дефекты</span>
            </div>
            <div class="legend-item">
                <div class="legend-color empty"></div>
                <span><i class="bi bi-slash-circle"></i> Нет сетевой точки</span>
            </div>
        </div>

        <!-- Краткая статистика -->
        <?php
        // Подсчет статистики
        $totalWorkstations = 12;
        $activeCount = 0;
        $defectCount_total = 0;
        $emptyCount = 0;

        $workstationMap = [
            1 => 1, 2 => 2, 3 => 3, 4 => 4,
            5 => 5, 6 => 6, 7 => 7, 8 => 8,
            9 => 13, 10 => 14, 11 => 15, 12 => 16
        ];

        $allPointIds = [];
        foreach ($allPoints as $point) {
            $allPointIds[] = $point['id'];
        }

        foreach ($workstationMap as $pointId) {
            if (!in_array($pointId, $allPointIds)) {
                $emptyCount++;
            } elseif (isset($defectCount[$pointId]) && $defectCount[$pointId] > 0) {
                $defectCount_total++;
            } else {
                $activeCount++;
            }
        }
        ?>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-number"><?= $totalWorkstations ?></div>
                <div class="stat-label">Всего мест</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #28a745;"><?= $activeCount ?></div>
                <div class="stat-label">Исправно</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #dc3545;"><?= $defectCount_total ?></div>
                <div class="stat-label">С дефектами</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #6c757d;"><?= $emptyCount ?></div>
                <div class="stat-label">Нет точки</div>
            </div>
        </div>

        <!-- Сетка компьютеров -->
        <div class="workstations-grid">
            <?php
            // Массив: номер ПК => ID сетевой точки
            $workstations = [
                1 => 1, 2 => 2, 3 => 3, 4 => 4,
                5 => 5, 6 => 6, 7 => 7, 8 => 8,
                9 => 13, 10 => 14, 11 => 15, 12 => 16
            ];

            // ID точек для быстрой проверки
            $existingPointIds = [];
            foreach ($allPoints as $point) {
                $existingPointIds[] = $point['id'];
            }

            foreach ($workstations as $pcNumber => $pointId):
                // Проверяем есть ли точка
                $hasPoint = in_array($pointId, $existingPointIds);

                // Проверяем есть ли дефекты
                $hasDefect = $hasPoint && isset($defectCount[$pointId]) && $defectCount[$pointId] > 0;
                $defectCountValue = $hasDefect ? $defectCount[$pointId] : 0;

                // Определяем класс и текст
                if (!$hasPoint) {
                    $statusClass = 'status-empty';
                    $icon = '<i class="bi bi-question-circle" style="color: #6c757d;"></i>';
                    $statusText = 'Нет точки';
                    $statusTextClass = 'empty';
                } elseif ($hasDefect) {
                    $statusClass = 'status-defect';
                    $icon = '<i class="bi bi-exclamation-triangle-fill" style="color: #dc3545;"></i>';
                    $statusText = $defectCountValue . ' дефект(а)';
                    $statusTextClass = 'defect';
                } else {
                    $statusClass = 'status-ok';
                    $icon = '<i class="bi bi-check-circle-fill" style="color: #28a745;"></i>';
                    $statusText = 'Исправно';
                    $statusTextClass = 'ok';
                }
            ?>
                <div class="workstation-card <?= $statusClass ?>"
                     onclick="window.location.href='controllers/defects.controller.php'"
                     title="Нажмите для просмотра дефектов">

                    <div class="status-icon">
                        <?= $icon ?>
                    </div>

                    <div class="pc-number">
                        ПК <?= $pcNumber ?>
                    </div>

                    <div class="status-text <?= $statusTextClass ?>">
                        <?= $statusText ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php include __DIR__ . '/components/footer.view.php'; ?>
