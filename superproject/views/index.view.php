<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}

$zoom_physic  = isset($_GET['zoom_physic']) ? (float)$_GET['zoom_physic'] : 1.0;
$zoom_network = isset($_GET['zoom_network']) ? (float)$_GET['zoom_network'] : 1.0;

include __DIR__ . '/components/header.view.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Планы кабинета 319Б</h2>

    <style>
        .zoom-wrapper {
            overflow: auto;
            max-height: 480px;
            border: 1px solid #dee2e6;
            background-color: #fff;
            border-radius: 4px;
        }

        .zoom-target {
            transform-origin: 0 0;
<<<<<<< Updated upstream
            transition: transform 0.2s ease;
=======
>>>>>>> Stashed changes
        }

        .svg-container svg {
            width: 100% !important;
            height: auto !important;
            display: block;
        }

        #physic-zoom {
            transform: scale(<?= $zoom_physic ?>);
        }

        #network-zoom {
            transform: scale(<?= $zoom_network ?>);
        }
<<<<<<< Updated upstream
=======

        <?php foreach ($locationsWithStatus as $l): 
            $color = ($l['defect_count'] > 0) ? '#dc3545' : '#198754';
        ?>
            #pc-<?= $l['id'] ?> circle,
            #pc-<?= $l['id'] ?> rect,
            #pc-<?= $l['id'] ?> ellipse {
                fill: <?= $color ?> !important;
                stroke: <?= $color ?> !important;
            }
        <?php endforeach; ?>
>>>>>>> Stashed changes
    </style>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Физический план</h5>
                    
                    <div class="btn-group">
                        <a href="?zoom_physic=<?= $zoom_physic + 0.2 ?>&zoom_network=<?= $zoom_network ?>" class="btn btn-sm btn-light">+</a>
                        <a href="?zoom_physic=<?= max(0.4, $zoom_physic - 0.2) ?>&zoom_network=<?= $zoom_network ?>" class="btn btn-sm btn-light">-</a>
                        <a href="?zoom_physic=1.0&zoom_network=<?= $zoom_network ?>" class="btn btn-sm btn-light">↺</a>
                    </div>
                </div>
                <div class="card-body bg-light p-3 text-center">
                    <div class="zoom-wrapper">
                        <div id="physic-zoom" class="zoom-target">
                            <?php 
                            $physicPath = __DIR__ . '/../uploads/physic.svg';
                            if (file_exists($physicPath)): 
                            ?>
                                <div class="svg-container">
                                    <?= file_get_contents($physicPath) ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning py-4 my-3 m-2">
                                    <h5>Файл physic.svg не найден</h5>
                                    <p class="mb-0 small">Пожалуйста, загрузите физическую схему physic.svg в папку uploads</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Сетевой план</h5>
                    
                    <div class="btn-group">
                        <a href="?zoom_physic=<?= $zoom_physic ?>&zoom_network=<?= $zoom_network + 0.2 ?>" class="btn btn-sm btn-light">+</a>
                        <a href="?zoom_physic=<?= $zoom_physic ?>&zoom_network=<?= max(0.4, $zoom_network - 0.2) ?>" class="btn btn-sm btn-light">-</a>
                        <a href="?zoom_physic=<?= $zoom_physic ?>&zoom_network=1.0" class="btn btn-sm btn-light">↺</a>
                    </div>
                </div>
                <div class="card-body bg-light p-3 text-center">
                    <div class="zoom-wrapper">
                        <div id="network-zoom" class="zoom-target">
                            <?php 
<<<<<<< Updated upstream
                            $networkPath = __DIR__ . '/../uploads/network.svg';
=======
                            $networkPath = __DIR__ . '/../uploads/Диаграмма без названия.drawio (1).svg';
>>>>>>> Stashed changes
                            if (file_exists($networkPath)): 
                            ?>
                                <div class="svg-container">
                                    <?= file_get_contents($networkPath) ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning py-4 my-3 m-2">
                                    <h5>Файл network.svg не найден</h5>
                                    <p class="mb-0 small">Пожалуйста, загрузите сетевую схему network.svg в папку uploads</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include __DIR__ . '/components/footer.view.php'; 
<<<<<<< Updated upstream
?>
=======
?>
>>>>>>> Stashed changes
