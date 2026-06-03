<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>авторизация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <button type="submit">Зарегистрироваться</button>
</form>
</body>
</html>
