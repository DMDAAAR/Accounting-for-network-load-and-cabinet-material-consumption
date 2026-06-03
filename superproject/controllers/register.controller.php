<?php
define('APP_LOADED', true);

session_start();

if (isset($_SESSION['user'])) {
    header('Location: dashboard.controller.php');
    exit();
}

require_once '../db/connectDB.php';
require_once '../models/user.models.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include '../views/register.view.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['login'])) {
        $login = trim($_POST['login']);
    } else {
        $login = '';
    }
    
    
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }
    
    if (isset($_POST['password_confirm'])) {
        $passwordConfirm = $_POST['password_confirm'];
    } else {
        $passwordConfirm = '';
    }
    
    //1) поля не пустые
    if ($login == '' || $password == '' || $passwordConfirm == '') {
        $_SESSION['flash_error'] = 'Заполните все поля';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    //2) длина логина от 3 до 50
    $loginLength = strlen($login);
    if ($loginLength < 3) {
        $_SESSION['flash_error'] = 'Логин должен быть не менее 3 символов';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    if ($loginLength > 50) {
        $_SESSION['flash_error'] = 'Логин не должен превышать 50 символов';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    //3) логин только из допустимых символов
    if (!preg_match('/^[a-zA-Z0-9а-яА-Я_-]+$/u', $login)) {
        $_SESSION['flash_error'] = 'Логин может содержать только буквы, цифры, _ и -';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    //4) логин не должен начинаться или заканчиваться пробелом
    if ($login != trim($login)) {
        $_SESSION['flash_error'] = 'Логин не должен содержать пробелы в начале или конце';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    //5) пароль не короче 4 символов
    if (strlen($password) < 4) {
        $_SESSION['flash_error'] = 'Пароль должен быть не менее 4 символов';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    //6) пароль не длиннее 100 символов
    if (strlen($password) > 100) {
        $_SESSION['flash_error'] = 'Пароль не должен превышать 100 символов';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    //7) пароль не должен состоять только из пробелов
    if (trim($password) == '') {
        $_SESSION['flash_error'] = 'Пароль не может состоять только из пробелов';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    //8) пароли совпадают
    if ($password != $passwordConfirm) {
        $_SESSION['flash_error'] = 'Пароли не совпадают';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    // 10) защита от вредоносного кода в логине
    $loginSafe = htmlspecialchars($login, ENT_QUOTES, 'UTF-8');
    if ($loginSafe != $login) {
        $_SESSION['flash_error'] = 'Логин содержит недопустимые символы';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    // 10) вызов функции создания пользователя 
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
