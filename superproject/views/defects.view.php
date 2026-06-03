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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Журнал поломок - Учёт ЛВС</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.controller.php">Учёт ЛВС</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Переключатель навигации">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="#">Главная</a>
                    <a class="nav-link active" aria-current="page" href="../controllers/defects.controller.php">Журнал поломок</a>
                    <a class="nav-link" href="#">Оборудование</a>
                    <a class="nav-link" href="#">Материалы</a>
                    <a class="nav-link" href="../controllers/logout.controller.php">Выход</a>
                </div>
            </div>
        </div>
    </nav>

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form class="d-flex" role="search" method="GET" action="defects.controller.php">
                <input class="form-control me-2" type="search" name="search" placeholder="Поиск по описанию" aria-label="Поиск">
                <button class="btn btn-outline-secondary" type="submit">Поиск</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Журнал поломок</h2>
                </div>
                <?php if (isset($_SESSION['flash_error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['flash_success'])): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                    </div>
                <?php endif; ?>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Добавить новую поломку</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../controllers/defects.controller.php">
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание проблемы</label>
                                <textarea class="form-control" 
                                          id="description" 
                                          name="description" 
                                          rows="3" 
                                          placeholder="..."
                                          required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить дефект</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Список поломок</h5>
                    </div>
                    <div class="card-body">
                        
                        <?php if (count($defects) == 0): ?>
                            <div class="alert alert-info">
                            Пока нет ни одной поломки.
                            </div>
                        <?php else: ?>
                            <div class="list-group">
                                <?php foreach ($defects as $defect): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong> Дефект #<?php echo htmlspecialchars($defect['id']); ?></strong>
                                            <small class="text-muted">
                                                <?php 
                                                    $date = date('d.m.Y H:i', strtotime($defect['created_at']));
                                                    echo htmlspecialchars($date);
                                                ?>
                                            </small>
                                        </div>
                                        <p class="mt-2 mb-1">
                                            <?php echo nl2br(htmlspecialchars($defect['description'])); ?>
                                        </p>
                                        <div>
                                            <?php if ($defect['status'] == 'open'): ?>
                                                <span class="badge bg-danger">Открыт</span>
                                            <?php elseif ($defect['status'] == 'in_progress'): ?>
                                                <span class="badge bg-warning">В работе</span>
                                            <?php elseif ($defect['status'] == 'closed'): ?>
                                                <span class="badge bg-success">Закрыт</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($defect['status']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <footer class="d-flex flex-wrap justify-content-between align-items-center pt-3 mt-5 text-muted small border-top">
        <div class="col-md-4 mb-0">© <?php echo date('Y'); ?> УЧЁТ ЛВС — система мониторинга сети</div>
        <div class="col-md-4 d-flex justify-content-end">
            <span>Журнал поломок</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>