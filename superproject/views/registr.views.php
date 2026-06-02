<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>авторизация</title>
    <link rel="stylesheet" href="/superproject/views/main.css">
</head>
<body>
<form action="" method="post">

    <label>Логин</label>
    <input type="text" name="username" placeholder="Введите свой логин">
    <label>Пароль</label>
    <input type="password" name="password" placeholder="Введите пароль">
    <label>Потверждение пароля</label>
    <input type="password" name="password_hash" placeholder="Потвердите пароль">
    <p>
        у вас уже есть аккаунт? - <a href="login.views.php">Войдите</a>
    </p>
    <button type="submit">Войти</button>
</form>
</body>
</html>
