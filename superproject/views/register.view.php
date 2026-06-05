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
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
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
            На главную <a href="../superproject/index.php">Назад</a>
        </div>
    </div>
</body>
</html>
