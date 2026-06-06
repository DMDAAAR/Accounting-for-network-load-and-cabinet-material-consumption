<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление материалами</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include __DIR__ . '/components/header.view.php'; ?>

<div class="container mt-4">
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= isset($editableMaterial) ? "Редактирование материала #{$editableMaterial['id']}" : "Новый материал" ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <?php if (isset($editableMaterial)): ?>
                            <input type="hidden" name="id" value="<?= $editableMaterial['id'] ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" required maxlength="100"
                                   value="<?= htmlspecialchars($editableMaterial['name'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Тип</label>
                            <select name="type" class="form-select" required>
                                <option value="">Выберите тип</option>
                                <?php
                                $types = ['cable' => 'Кабель (cable)', 'connector' => 'Коннектор (connector)', 'socket' => 'Розетка (socket)', 'fastener' => 'Крепеж (fastener)'];
                                foreach ($types as $val => $label):
                                    $selected = (isset($editableMaterial) && $editableMaterial['type'] == $val) ? 'selected' : '';
                                ?>
                                    <option value="<?= $val ?>" <?= $selected ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Единица измерения</label>
                            <select name="unit" class="form-select" required>
                                <option value="">Выберите единицу</option>
                                <?php
                                $units = ['m' => 'Метры (m)', 'pcs' => 'Штуки (pcs)'];
                                foreach ($units as $val => $label):
                                    $selected = (isset($editableMaterial) && $editableMaterial['unit'] == $val) ? 'selected' : '';
                                ?>
                                    <option value="<?= $val ?>" <?= $selected ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Количество</label>
                            <input type="number" name="quantity" class="form-control" min="0" step="0.01" required
                                   value="<?= isset($editableMaterial) ? htmlspecialchars($editableMaterial['quantity']) : '0' ?>">
                        </div>

                        <button type="submit" class="btn btn-primary w-100"><?= isset($editableMaterial) ? "Сохранить" : "Добавить" ?></button>
                        <?php if (isset($editableMaterial)): ?>
                            <a href="materials.controller.php" class="btn btn-secondary w-100 mt-2">Отмена</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h4 class="mb-3">Список материалов <span class="badge bg-secondary"><?= count($materials) ?></span></h4>
            <?php if (empty($materials)): ?>
                <div class="alert alert-info">Материалы отсутствуют</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Тип</th>
                                <th>Кол-во</th>
                                <th>Ед.</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materials as $m): ?>
                                <tr>
                                    <td><?= $m['id'] ?></td>
                                    <td><?= htmlspecialchars($m['name']) ?></td>
                                    <td><?= htmlspecialchars($m['type']) ?></td>
                                    <td><?= htmlspecialchars($m['quantity']) ?></td>
                                    <td><?= htmlspecialchars($m['unit']) ?></td>
                                    <td>
                                        <a href="?edit_id=<?= $m['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Изменить
                                        </a>
                                        <form method="POST" style="display:inline" onsubmit="return confirm('Удалить материал?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="delete_id" value="<?= $m['id'] ?>">
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Удалить
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/components/footer.view.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
