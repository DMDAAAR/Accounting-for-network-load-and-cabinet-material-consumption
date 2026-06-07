<?php

if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}

session_start();

$oldLogin = $_SESSION['old_login'] ?? '';
unset($_SESSION['old_login']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - Учёт ЛВС</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f0f2f5;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            padding: 10px;
            background: #ffe6e6;
            border-radius: 5px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
            padding: 10px;
            background: #e6ffe6;
            border-radius: 5px;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #007bff;
            text-decoration: none;
        }
        .link a:hover {
            text-decoration: underline;
        }
        hr {
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Вход в систему</h2>
    <p style="text-align: center; color: #666;">Кабинет 319Б</p>

    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="error">
            × <?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="success">
            ✓ <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="../controllers/login.controller.php">
        <label>Логин</label>
        <input type="text"
               name="login"
               value="<?php echo htmlspecialchars($oldLogin); ?>"
               placeholder="Введите логин"
               required>

        <label>Пароль</label>
        <input type="password"
               name="password"
               placeholder="Введите пароль"
               required>

        <button type="submit">Войти</button>
    </form>

    <hr>

    <div class="link">
        Нет аккаунта? <a href="../controllers/register.controller.php">Зарегистрироваться</a>
    </div>
    <div class="link">
        На главную <a href="<?= BASE_URL ?>index.php">Назад</a>   <!-- исправлено -->
    </div>
</div>
</body>
</html>