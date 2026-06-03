<?php
//header("Location: controllers/login.controller.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>главная страница</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Учёт ЛВС</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="#">Главная</a>
                <a class="nav-link" href="../controllers/login.controller.php">Вход</a>
                <a class="nav-link" href="../controllers/register.controller.php">Регистрация</a>
            </div>
            </div>
        </div>
    </nav>

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск">
            <button class="btn btn-outline-secondary" type="submit">Поиск</button>
            </form>
        </div>
    </nav>

    <footer class="d-flex flex-wrap justify-content-between align-items-center pt-3 mt-2 text-muted small">
        <div class="col-md-4 mb-0">© <?= date('Y') ?> УЧЁТ ЛВС — система мониторинга сети</div>
        <div class="col-md-4 d-flex justify-content-end">
            <span><i class="bi bi-shield-check me-1"></i> Версия 1.0 | Все права защищены</span>
        </div>
    </footer>
</body>
</html>