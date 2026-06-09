<?php
<<<<<<< Updated upstream
// Убираем проверку APP_LOADED - она уже есть в контроллере
=======
>>>>>>> Stashed changes
include __DIR__ . '/components/header.view.php';
?>
<div class="container mt-4">
    <!-- Выводим сообщения -->
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
<<<<<<< Updated upstream
    <h2 class="mb-4">Управление оборудованием</h2>
=======
    
    <?php if (isset($_SESSION['flash_info'])): ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['flash_info']); unset($_SESSION['flash_info']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <h2 class="mb-4">Управление оборудованием</h2>
    
>>>>>>> Stashed changes
    <!-- ФОРМА ПОИСКА -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="inventory.controller.php" method="get" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control"
                           placeholder="Поиск по названию точки..."
                           value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Найти</button>
                    <?php if (!empty($search)): ?>
                        <a href="inventory.controller.php" class="btn btn-secondary">Сбросить</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
<<<<<<< Updated upstream
    <!-- ФОРМА ДОБАВЛЕНИЯ / РЕДАКТИРОВАНИЯ -->
=======
>>>>>>> Stashed changes
    <div class="card mb-4">
        <div class="card-header <?= $edit_point ? 'bg-warning' : 'bg-primary' ?> text-white">
            <h5 class="mb-0">
                <?= $edit_point ? "Редактирование точки: " . htmlspecialchars($edit_point['label']) : "Добавление новой точки" ?>
            </h5>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <input type="hidden" name="action" value="<?= $edit_point ? 'edit' : 'add' ?>">

                <?php if ($edit_point): ?>
                    <input type="hidden" name="id" value="<?= $edit_point['id'] ?>">
                <?php endif; ?>

                <div class="col-md-4">
                    <label class="form-label">Название точки</label>
                    <input type="text" name="label" class="form-control" required
                           value="<?= $edit_point ? htmlspecialchars($edit_point['label']) : '' ?>"
                           placeholder="Пример: Розетка-01">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Тип</label>
                    <select name="type" class="form-select">
                        <?php $currType = $edit_point ? $edit_point['type'] : 'socket'; ?>
                        <option value="socket" <?= $currType == 'socket' ? 'selected' : '' ?>>Розетка</option>
                        <option value="switch" <?= $currType == 'switch' ? 'selected' : '' ?>>Коммутатор</option>
                        <option value="cable_run" <?= $currType == 'cable_run' ? 'selected' : '' ?>>Кабель</option>
                        <option value="patch_cord" <?= $currType == 'patch_cord' ? 'selected' : '' ?>>Патч-корд</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Статус</label>
                    <select name="status" class="form-select">
                        <?php $currStatus = $edit_point ? $edit_point['status'] : 'active'; ?>
                        <option value="active" <?= $currStatus == 'active' ? 'selected' : '' ?>>Активен</option>
                        <option value="defect" <?= $currStatus == 'defect' ? 'selected' : '' ?>>Дефект</option>
                        <option value="decommissioned" <?= $currStatus == 'decommissioned' ? 'selected' : '' ?>>Списано</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Кабинет</label>
                    <select name="location_id" class="form-select">
                        <option value="">-- Не выбран --</option>
                        <?php foreach ($rooms as $room): ?>
                            <?php $selected = ($edit_point && $edit_point['location_id'] == $room['id']) ? 'selected' : ''; ?>
                            <option value="<?= $room['id'] ?>" <?= $selected ?>>
                                <?= htmlspecialchars($room['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 text-end">
                    <?php if ($edit_point): ?>
                        <a href="inventory.controller.php" class="btn btn-secondary">Отмена</a>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-success">
                        <?= $edit_point ? "Сохранить" : "Добавить" ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
<<<<<<< Updated upstream
    <!-- ТАБЛИЦА СО ВСЕМИ ТОЧКАМИ -->
=======
>>>>>>> Stashed changes
    <h4 class="mb-3">Список всех точек сети</h4>

    <?php if (!empty($points)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Тип</th>
                        <th>Статус</th>
<<<<<<< Updated upstream
                        <th>Кабинет</th>
                        <th width="150">Действия</th>
=======
                        <th>Локация</th>
                        <th class="text-center">Материалы</th>
                        <th class="text-center">Действия</th>
>>>>>>> Stashed changes
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($points as $point): ?>
                        <tr>
                            <td><?= $point['id'] ?></td>
                            <td><strong><?= htmlspecialchars($point['label']) ?></strong></td>
                            <td><?= htmlspecialchars($point['type']) ?></td>
                            <td>
                                <?php
                                $badge = 'secondary';
                                if ($point['status'] == 'active') $badge = 'success';
                                if ($point['status'] == 'defect') $badge = 'danger';
<<<<<<< Updated upstream
                                ?>
                                <span class="badge bg-<?= $badge ?>"><?= $point['status'] ?></span>
                            </td>
                            <td><?= htmlspecialchars($point['location_name'] ?? '—') ?></td>
                            <td>
                                <a href="?edit_id=<?= $point['id'] ?>" class="btn btn-sm btn-warning">Изменить</a>
                                <a href="?action=delete&id=<?= $point['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Удалить точку?')">Удалить</a>
=======
                                if ($point['status'] == 'decommissioned') $badge = 'dark';
                                ?>
                                <span class="badge bg-<?= $badge ?>"><?= $point['status'] ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($point['location_name'] ?? '—'); ?></td>
                            
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#materialsModal<?php echo $point['id']; ?>">
                                    Подробнее (<?php echo count($point['materials']); ?>)
                                </button>
                            </td>
                            <td class="text-center">
                                <a href="inventory.controller.php?edit_id=<?php echo $point['id']; ?>" 
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Изменить
                                </a>
                                <a href="?action=delete&id=<?= $point['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Удалить точку?')">
                                    <i class="bi bi-trash"></i> Удалить
                                </a>
>>>>>>> Stashed changes
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- ПАГИНАЦИЯ -->
        <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">Назад</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
<<<<<<< Updated upstream
<li class="page-item <?= $i == $page ? 'active' : '' ?>">
=======
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
>>>>>>> Stashed changes
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Вперед</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
<<<<<<< Updated upstream

    <?php else: ?>
        <div class="alert alert-info text-center">
            Точки сети не найдены
        </div>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/components/footer.view.php'; ?>
=======

    <?php else: ?>
        <div class="alert alert-info text-center">
            <td colspan="7" class="text-center text-muted">Данные о точках сети отсутствуют или не переданы из контроллера</td>
        </div>
    <?php endif; ?>
</div>

<!-- МОДАЛЬНЫЕ ОКНА ДЛЯ МАТЕРИАЛОВ -->
<?php if (isset($points) && is_array($points)): ?>
    <?php foreach ($points as $point): ?>
        <div class="modal fade" id="materialsModal<?php echo $point['id']; ?>" tabindex="-1" aria-labelledby="materialsModalLabel<?php echo $point['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="materialsModalLabel<?php echo $point['id']; ?>">
                            Расход материалов для: <?php echo htmlspecialchars($point['label']); ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($point['materials'])): ?>
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Название материала</th>
                                        <th>Количество</th>
                                        <th>Дата списания</th>
                                        <th>Кто производил ремонт</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($point['materials'] as $mat): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($mat['material_name']); ?></td>
                                            <td><?php echo floatval($mat['quantity']) . ' ' . htmlspecialchars($mat['unit']); ?></td>
                                            <td><?php echo date('d.m.Y H:i', strtotime($mat['used_at'])); ?></td>
                                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($mat['user_name']); ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">Материалы для обслуживания данной точки сети еще не списывались.</div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php 
include __DIR__ . '/components/footer.view.php'; 
?>
>>>>>>> Stashed changes
