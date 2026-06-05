<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Учёт ЛВС</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ---------- Глобальные стили ---------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f7fc;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', system-ui, sans-serif;
            color: #1e2a3e;
            line-height: 1.5;
        }

        /* ---------- Навигация ---------- */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #2b7a4b, #5fad56);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent !important;
            letter-spacing: -0.3px;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: #2c3e4e !important;
            margin: 0 0.25rem;
            border-radius: 40px;
            transition: all 0.2s;
        }

        .navbar-nav .nav-link:hover {
            background: #eef2f5;
            color: #1f6e43 !important;
        }

        .navbar-nav .nav-link.active {
            background: #e9f5ef;
            color: #2b7a4b !important;
            font-weight: 600;
        }

        /* ---------- Кнопки (салатовые и другие) ---------- */
        .btn-custom-green {
            background-color: #9bdd7c;
            color: #1e3a2f;
            border: none;
            font-weight: 600;
            border-radius: 40px;
            padding: 0.5rem 1.25rem;
            transition: all 0.2s ease;
        }
        .btn-custom-green:hover {
            background-color: #7bcb5e;
            transform: translateY(-1px);
            color: #0f2a1f;
            box-shadow: 0 4px 10px rgba(100, 200, 100, 0.2);
        }

        .btn-outline-secondary {
            border-radius: 40px;
            border: 1px solid #cbd5e1;
            color: #2c5a74;
            background: white;
            transition: 0.2s;
        }
        .btn-outline-secondary:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        /* Общие стили для кнопок */
        .btn {
            border-radius: 40px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background: #2c7a4d;
            border: none;
        }
        .btn-primary:hover {
            background: #236b41;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(44, 122, 77, 0.2);
        }
        .btn-danger {
            background: #e25c5c;
        }
        .btn-danger:hover {
            background: #d14b4b;
        }
        .btn-warning {
            background: #f0b429;
            color: #2d2b1f;
        }
        .btn-warning:hover {
            background: #e0a81c;
        }

        /* ---------- Форма поиска (доп. навбар) ---------- */
        .navbar.bg-body-tertiary {
            background: #ffffff !important;
            margin-top: 0;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #eef2f8;
        }

        /* ---------- Карточки ---------- */
        .card {
            border: none;
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.03), 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #edf2f7;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .card-body {
            padding: 1.5rem;
        }

        /* ---------- Таблицы ---------- */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        .table thead th {
            background: #f8fafc;
            color: #1f3b4c;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #ecf3f9;
            color: #253c4b;
        }
        .table-hover tbody tr:hover {
            background-color: #fafef7;
        }

        /* ---------- Формы ---------- */
        input, select, textarea {
            border-radius: 16px;
            border: 1px solid #dce5ec;
            padding: 0.6rem 1rem;
            transition: 0.2s;
            width: 100%;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #7bcb8c;
            box-shadow: 0 0 0 3px rgba(100, 200, 120, 0.2);
            outline: none;
        }
        label {
            font-weight: 500;
            color: #2a4d68;
            margin-bottom: 0.3rem;
        }

        /* ---------- Пагинация ---------- */
        .pagination .page-link {
            border-radius: 40px;
            margin: 0 3px;
            border: none;
            color: #2f5e7e;
            background: #f1f4f8;
            transition: all 0.2s;
        }
        .pagination .page-item.active .page-link {
            background: #2c7a4d;
            color: white;
            box-shadow: 0 2px 6px rgba(44,122,77,0.3);
        }
        .pagination .page-link:hover {
            background: #e2eaf1;
            transform: translateY(-1px);
        }

        /* ---------- Адаптивность ---------- */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
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
                <a class="nav-link" href="controllers/useMaterial.controller.php">Материалы</a>
                <a class="nav-link" href="controllers/defects.controller.php">Дефекты</a>
                <a class="nav-link" href="controllers/login.controller.php">Вход</a>
                <a class="nav-link" href="controllers/register.controller.php">Регистрация</a>
                <a class="nav-link" href="controllers/logout.controller.php">Выход</a>
            </div>
        </div>
    </div>
</nav>

<!-- Форма поиска -->
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <form class="d-flex w-100" method="GET" action="index.php">
            <input class="form-control me-2" type="search" name="search"
                   placeholder="Поиск по точкам сети..."
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button class="btn btn-outline-secondary" type="submit">Поиск</button>
        </form>
    </div>
</nav>