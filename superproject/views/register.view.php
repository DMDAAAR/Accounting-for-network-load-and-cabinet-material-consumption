<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/superproject/views/main.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow">
            <div class="card-body">
                <form action="" method="post">
                    <div class="alert alert-danger" role="alert" style="display: none;"></div>
                    <label>Имя</label>
                    <input type="text" class="form-control" name="username" placeholder="Baguette cook room">
                    <label>Пароль</label>
                    <input type="password" class="form-control" name="password_hash" placeholder="Password room">
                    <button type="submit" class="btn-custom-green">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
