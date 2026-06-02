<?php
// Защита от прямого вызова
define('APP_LOADED', true);

session_start();

// Проверка залогинен ли пользователь
if (isset($_SESSION['user'])) {
    header('Location: dashboard.controller.php');
    exit();
}

require_once '../connectDB.php';
require_once '../models/user.model.php';

// запрос - показать форму регистрации
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include '../views/register.view.php';
    exit();
}

// запрос - обработать регистрацию
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    //  логин из формы
    if (isset($_POST['login'])) {
        $login = trim($_POST['login']);
    } else {
        $login = '';
    }
    
    //  пароль из формы
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }
    
    // подтверждение пароля из формы
    if (isset($_POST['password_confirm'])) {
        $passwordConfirm = $_POST['password_confirm'];
    } else {
        $passwordConfirm = '';
    }
    
    // Проверка 1: поля не пустые
    if ($login == '' || $password == '' || $passwordConfirm == '') {
        $_SESSION['flash_error'] = 'Заполните все поля';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    // Проверка 2: пароль не короче 4 символов
    if (strlen($password) < 4) {
        $_SESSION['flash_error'] = 'Пароль должен быть не менее 4 символов';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    // Проверка 3: пароли совпадают
    if ($password != $passwordConfirm) {
        $_SESSION['flash_error'] = 'Пароли не совпадают';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    // вызов функции
    $result = createUser($pdo, $login, $password, 'operator');
    
    if ($result == true) {
        $_SESSION['flash_success'] = 'Регистрация прошла успешно! Теперь вы можете войти.';
        header('Location: login.controller.php');
        exit();
    } else {
        $_SESSION['flash_error'] = 'Пользователь с таким логином уже существует';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
}
?>