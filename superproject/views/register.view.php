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
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/superproject/css/login.css">
</head>
<body>
<div class="container">
    <h2>Регистрация</h2>
    <p style="text-align: center; color: #666;">Создайте новый аккаунт</p>

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

    <form method="POST" action="../controllers/register.controller.php">
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

        <label>Подтверждение пароля</label>
        <input type="password"
               name="password_confirm"
               placeholder="Повторите пароль"
               required>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <hr>

    <div class="link">
        Уже есть аккаунт? <a href="../controllers/login.controller.php">Войти</a>
    </div>
    <div class="link">
        На главную <a href="<?= BASE_URL ?>index.php">Назад</a>   <!-- исправлено -->
    </div>
</div>
</body>
</html>