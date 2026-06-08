<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Дефекты ЛВС</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .defect-card {
            transition: 0.2s;
            border-left: 4px solid;
            margin-bottom: 20px;
        }
        .border-open { border-left-color: #dc3545; }
        .border-progress { border-left-color: #ffc107; }
        .border-closed { border-left-color: #198754; }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }
        .defect-photo {
            max-height: 150px;
            max-width: 100%;
            border-radius: 8px;
            cursor: pointer;
            object-fit: contain;
        }
    </style>
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
                    <h5 class="mb-0"><?= isset($editableDefect) ? "Редактирование #{$editableDefect['id']}" : "Новый дефект" ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <?php if (isset($editableDefect)): ?>
                            <input type="hidden" name="id" value="<?= $editableDefect['id'] ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Название поломки</label>
                            <input type="text" name="title" class="form-control" required
                                   value="<?= htmlspecialchars($editableDefect['title'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" rows="3" class="form-control" required><?= htmlspecialchars($editableDefect['description'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Точка сети</label>
                            <select name="point_id" class="form-select" required>
                                <?php foreach ($networkPoints as $point): ?>
                                    <option value="<?= $point['id'] ?>" <?= (isset($editableDefect) && $editableDefect['point_id'] == $point['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($point['label']) ?> (ID <?= $point['id'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Фото (необязательно)</label>
                            <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                            <?php if (isset($editableDefect) && !empty($editableDefect['photo_path'])): ?>
                                <div class="mt-2">
                                    <img src="<?= htmlspecialchars($editableDefect['photo_path']) ?>" alt="Текущее фото" style="max-height: 100px; border-radius: 5px;">
                                    <small class="text-muted d-block">Текущее фото</small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (isset($editableDefect)): ?>
                            <div class="mb-3">
                                <label class="form-label">Статус</label>
                                <select name="status" class="form-select">
                                    <option value="open" <?= $editableDefect['status'] == 'open' ? 'selected' : '' ?>>Открыт</option>
                                    <option value="in_progress" <?= $editableDefect['status'] == 'in_progress' ? 'selected' : '' ?>>В работе</option>
                                    <option value="closed" <?= $editableDefect['status'] == 'closed' ? 'selected' : '' ?>>Закрыт</option>
                                </select>
                            </div>
                        <?php endif; ?>

                        <button type="submit" class="btn btn-primary w-100"><?= isset($editableDefect) ? "Сохранить" : "Добавить" ?></button>
                        <?php if (isset($editableDefect)): ?>
                            <a href="defects.controller.php" class="btn btn-secondary w-100 mt-2">Отмена</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- Список дефектов -->
        <div class="col-lg-8">
            <h4 class="mb-3">Журнал дефектов <span class="badge bg-secondary"><?= count($defects) ?></span></h4>
            <?php if (empty($defects)): ?>
                <div class="alert alert-info text-center">Дефектов пока нет</div>
            <?php else: ?>
                <div class="grid-container">
                    <?php foreach ($defects as $d):
                        switch ($d['status']) {
                            case 'open': $border = 'border-open'; $badge = 'bg-danger'; $statusText = 'Открыт'; break;
                            case 'in_progress': $border = 'border-progress'; $badge = 'bg-warning text-dark'; $statusText = 'В работе'; break;
                            default: $border = 'border-closed'; $badge = 'bg-success'; $statusText = 'Закрыт'; break;
                        }
                        ?>
                        <div class="card defect-card shadow-sm <?= $border ?>">
                            <div class="card-header bg-white d-flex justify-content-between">
                                <strong>#<?= $d['id'] ?> – <?= htmlspecialchars($d['title']) ?></strong>
                                <span class="badge <?= $badge ?>"><?= $statusText ?></span>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($d['photo_path'])): ?>
                                    <div class="mb-2 text-center">
                                        <img src="<?= htmlspecialchars($d['photo_path']) ?>" alt="Фото дефекта" class="defect-photo" onclick="window.open(this.src)">
                                    </div>
                                <?php endif; ?>
                                <p class="mb-2"><?= nl2br(htmlspecialchars($d['description'])) ?></p>
                                <small class="text-muted">
                                    <i class="bi bi-hdd-network"></i> Точка ID: <?= $d['point_id'] ?><br>
                                    <i class="bi bi-calendar3"></i> <?= date('d.m.Y H:i', strtotime($d['created_at'])) ?>
                                </small>
                            </div>
                            <div class="card-footer bg-white d-flex justify-content-end gap-2">
                                <a href="?edit_id=<?= $d['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Изменить</a>
                                <?php if ($d['status'] !== 'closed'): ?>
                                    <a href="defects.controller.php?fix_id=<?= $d['id'] ?>" class="btn btn-sm btn-success"><i class="bi bi-wrench"></i> Починить</a>
                                <?php endif; ?>
                                <form method="POST" style="display:inline" onsubmit="return confirm('Удалить дефект?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="delete_id" value="<?= $d['id'] ?>">
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Удалить</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
<?php if ($defect['status'] == 'closed'): ?>
    <div style="margin-top: 10px; padding-top: 8px; border-top: 1px solid #eee; font-size: 13px;">
        <strong>Материалы:</strong>
        <?php if (!empty($defect['used_materials'])): ?>
            <?php foreach ($defect['used_materials'] as $material): ?>
                <span style="background: #e9ecef; padding: 2px 8px; border-radius: 12px; margin-right: 5px;">
                    <?= htmlspecialchars($material['name']) ?>: <?= $material['quantity'] ?> <?= $material['unit'] ?>
                </span>
            <?php endforeach; ?>
        <?php else: ?>
            <span style="color: #666;">не списывались</span>
        <?php endif; ?>
    </div>
<?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/components/footer.view.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
