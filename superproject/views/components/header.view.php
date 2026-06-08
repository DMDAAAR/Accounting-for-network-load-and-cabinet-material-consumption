<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Учёт ЛВС</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .navbar-salad {
            background-color: #f0fff0 !important;
            border-bottom: 2px solid #90EE90;
        }
        .navbar-salad .navbar-brand,
        .navbar-salad .nav-link,
        .navbar-salad .navbar-text {
            color: #2c5e2c !important;
        }
        .navbar-salad .nav-link:hover {
            color: #1a4d1a !important;
            background-color: rgba(144, 238, 144, 0.2);
            border-radius: 8px;
        }
        .btn-salad-outline {
            border-color: #90EE90;
            color: #2c5e2c;
        }
        .btn-salad-outline:hover {
            background-color: #90EE90;
            color: #fff;
        }
        .btn-salad {
            background-color: #90EE90;
            border-color: #90EE90;
            color: #2c5e2c;
        }
        .btn-salad:hover {
            background-color: #7CFC00;
            border-color: #7CFC00;
            color: #1a4d1a;
        }
        .active-nav {
            font-weight: bold;
            border-bottom: 2px solid #2c5e2c;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            flex: 1;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-salad shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= BASE_URL ?>index.php"> Учёт ЛВС</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSalad">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSalad">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>controllers/inventory.controller.php">Оборудование</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>controllers/defects.controller.php">Дефекты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>controllers/materials.controller.php">Материалы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>controllers/report.controller.php">Отчёты</a>
                </li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>controllers/logs.controller.php">Логи</a>
            </li>
            <?php endif; ?>
            </ul>
            <div class="d-flex">
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="navbar-text me-3">
                        👤 <?= htmlspecialchars($_SESSION['user']['login']) ?>
                        (<?= htmlspecialchars($_SESSION['user']['role']) ?>)
                    </span>
                    <a href="<?= BASE_URL ?>controllers/logout.controller.php" class="btn btn-salad-outline btn-sm">Выход</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>controllers/login.controller.php" class="btn btn-salad-outline me-2 btn-sm">Вход</a>
                    <a href="<?= BASE_URL ?>controllers/register.controller.php" class="btn btn-salad btn-sm">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<div class="container mt-4">
