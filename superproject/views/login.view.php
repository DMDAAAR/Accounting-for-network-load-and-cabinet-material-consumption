<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/superproject/views/main.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4 fw-bold text-dark">Добро пожаловать</h2>
                        <p class="text-center text-muted mb-4">Войдите в свой аккаунт</p>
                        <?php if (isset($error) && $error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?php echo htmlspecialchars($error); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold">Имя пользователя</label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="username" 
                                       name="username" 
                                       placeholder="Введите ваше имя" 
                                       required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Пароль</label>
                                <input type="password" 
                                       class="form-control form-control-lg" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Введите пароль" 
                                       required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom-green btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Войти</button>
                            </div>
                            <div class="text-center mt-4">
                                <span class="text-muted">Нет аккаунта?</span>
                                <a href="/superproject/views/register.view.php" class="text-decoration-none fw-semibold ms-1" style="color: #2c7da0;">Зарегистрироваться</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
