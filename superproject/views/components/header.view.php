<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Учёт ЛВС</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="../">Главная</a>
                <a class="nav-link" href="controllers/inventory.controller.php">Оборудование</a>
                <a class="nav-link" href="controllers/login.controller.php">Вход</a>
                <a class="nav-link" href="controllers/register.controller.php">Регистрация</a>
            </div>
        </div>
    </div>
</nav>

<!-- Форма поиска -->
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <form class="d-flex" method="GET" action="index.php">
            <input class="form-control me-2" type="search" name="search"
                   placeholder="Поиск"
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button class="btn btn-outline-secondary" type="submit">Поиск</button>
        </form>
    </div>
</nav>