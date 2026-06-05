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
    <title>Журнал поломок</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .defect-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-left: 4px solid;
            margin-bottom: 20px;
        }
        .defect-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .card-header-small {
            font-size: 0.85rem;
        }
        .description-text {
            max-height: 100px;
            overflow-y: auto;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }
        .border-open {
            border-left-color: #dc3545;
        }
        .border-progress {
            border-left-color: #ffc107;
        }
        .border-closed {
            border-left-color: #198754;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Учёт ЛВС</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav">
                    <a class="nav-link" href="../index.php">Главная</a>
                    <a class="nav-link active" href="../controllers/defects.controller.php">Журнал поломок</a>
                    <a class="nav-link" href="../controllers/inventory.controller.php">Оборудование</a>
                    <a class="nav-link" href="../controllers/materials.controller.php">Материалы</a>
                    <a class="nav-link" href="../controllers/logout.controller.php">Выход</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Журнал поломок</h2>
            </div>
        </div>

        <?php if (isset($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Сообщить о поломке</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../controllers/defects.controller.php">
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание проблемы</label>
                                <textarea class="form-control" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="..."
                                          required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small">* Все поля обязательны для заполнения</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Отправить заявку
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="card mt-3 bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Информация</h6>
                        <p class="card-text small text-muted mb-0">
                            После отправки заявки, статус поломки автоматически устанавливается как <span class="badge bg-danger">Открыт</span>.
                            Заявка будет обработана в ближайшее время.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Список поломок</h4>
                    <span class="badge bg-secondary">Всего: <?php echo count($defects); ?></span>
                </div>
                
                <?php if (count($defects) == 0): ?>
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Пока нет поломок. Сообщите если что-то не так</p>
                    </div>
                <?php else: ?>
                    <div class="grid-container">
                        <?php foreach ($defects as $defect): ?>
                            <?php 
                                $borderClass = 'border-open';
                                $statusBadge = '';
                                $statusText = '';
                                
                                if ($defect['status'] == 'open') {
                                    $borderClass = 'border-open';
                                    $statusBadge = 'bg-danger';
                                    $statusText = 'Открыт';
                                } elseif ($defect['status'] == 'in_progress') {
                                    $borderClass = 'border-progress';
                                    $statusBadge = 'bg-warning text-dark';
                                    $statusText = 'В работе';
                                } elseif ($defect['status'] == 'closed') {
                                    $borderClass = 'border-closed';
                                    $statusBadge = 'bg-success';
                                    $statusText = 'Закрыт';
                                } else {
                                    $statusBadge = 'bg-secondary';
                                    $statusText = htmlspecialchars($defect['status']);
                                }
                            ?>
                            
                            <div class="card defect-card shadow-sm <?php echo $borderClass; ?>">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <strong class="text-primary">Дефект #<?php echo htmlspecialchars($defect['id']); ?></strong>
                                    <span class="badge <?php echo $statusBadge; ?>"><?php echo $statusText; ?></span>
                                </div>
                                <div class="card-body">
                                    <div class="description-text mb-3">
                                        <small class="text-muted">Описание:</small>
                                        <p class="mt-1 mb-0"><?php echo nl2br(htmlspecialchars($defect['description'])); ?></p>
                                    </div>
                                    <div class="text-muted small mt-2">
                                        <i class="bi bi-calendar3"></i> 
                                        <?php 
                                            $date = date('d.m.Y H:i', strtotime($defect['created_at']));
                                            echo htmlspecialchars($date);
                                        ?>
                                    </div>
                                </div>
                                <div class="card-footer bg-white text-muted card-header-small">
                                    <?php if ($defect['status'] == 'open'): ?>
                                        <span class="text-danger">Ожидает обработки</span>
                                    <?php elseif ($defect['status'] == 'in_progress'): ?>
                                        <span class="text-warning">В процессе ремонта</span>
                                    <?php elseif ($defect['status'] == 'closed'): ?>
                                        <span class="text-success">Ремонт завершён</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <footer class="d-flex flex-wrap justify-content-between align-items-center pt-3 mt-5 pb-3 text-muted small border-top">
        <div class="col-md-4 mb-0">© <?php echo date('Y'); ?> УЧЁТ ЛВС</div>
        <div class="col-md-4 d-flex justify-content-end">
            <span>Журнал поломок</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
