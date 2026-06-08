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
    <link rel="stylesheet" href="/superproject/css/login.css">
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