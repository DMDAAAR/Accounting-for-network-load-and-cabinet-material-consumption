<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Журнал поломок</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Учёт ЛВС</a>
        <div class="collapse navbar-collapse">
            <div class="navbar-nav">
                <a class="nav-link" href="../controllers/defects.controller.php">Журнал поломок</a>
                <a class="nav-link" href="../controllers/logout.controller.php">Выход</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">

            <h2>Журнал поломок</h2>

            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Форма добавления -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Добавить поломку</div>
                <div class="card-body">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="add">
                        <textarea class="form-control" name="description" rows="3" placeholder="Опишите проблему..." required></textarea>
                        <button type="submit" class="btn btn-primary mt-2">Добавить</button>
                    </form>
                </div>
            </div>

            <!-- Форма редактирования (показывается только если есть editDefect) -->
            <?php if (isset($editDefect) && $editDefect): ?>
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">Редактирование дефекта #<?= $editDefect['id'] ?></div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="defect_id" value="<?= $editDefect['id'] ?>">

                            <div class="mb-3">
                                <label class="form-label">Описание</label>
                                <textarea class="form-control" name="description" rows="3" required><?= htmlspecialchars($editDefect['description']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Статус</label>
                                <select class="form-select" name="status">
                                    <option value="open" <?= $editDefect['status'] == 'open' ? 'selected' : '' ?>>Открыт</option>
                                    <option value="in_progress" <?= $editDefect['status'] == 'in_progress' ? 'selected' : '' ?>>В работе</option>
                                    <option value="closed" <?= $editDefect['status'] == 'closed' ? 'selected' : '' ?>>Закрыт</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-warning">Сохранить изменения</button>
                            <a href="defects.controller.php" class="btn btn-secondary">Отмена</a>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Список поломок -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    Список поломок (<?= count($defects) ?>)
                </div>
                <div class="card-body">
                    <?php if (count($defects) == 0): ?>
                        <div class="alert alert-info">Нет зарегистрированных поломок</div>
                    <?php else: ?>
                        <?php foreach ($defects as $defect): ?>
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>Дефект #<?= $defect['id'] ?></strong>
                                        <br>
                                        <small class="text-muted">Создан: <?= date('d.m.Y H:i', strtotime($defect['created_at'])) ?></small>
                                    </div>
                                    <div>
                                        <?php if ($defect['status'] == 'open'): ?>
                                            <span class="">Открыт</span>
                                        <?php elseif ($defect['status'] == 'in_progress'): ?>
                                            <span class="badge bg-warning text-dark">В работе</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Закрыт</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <p class="mt-3 mb-3"><?= htmlspecialchars($defect['description']) ?></p>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="?edit_id=<?= $defect['id'] ?>" class="btn btn-warning btn-sm"> Изменить</a>
                                    <a href="?delete_id=<?= $defect['id'] ?>"
                                       onclick="return confirm('Вы уверены, что хотите удалить дефект #<?= $defect['id'] ?>? Это действие нельзя отменить.')"
                                       class="btn btn-danger btn-sm"> Удалить</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>