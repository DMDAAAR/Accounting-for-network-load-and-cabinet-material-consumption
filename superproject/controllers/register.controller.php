<?php
define('APP_LOADED', true);
if (!defined('BASE_URL')) {
    define('BASE_URL', '/');
}
session_start();

if (isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit();
}

require_once '../db/connectDB.php';
require_once '../models/user.model.php';

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
    
    if ($login == '' || $password == '' || $passwordConfirm == '') {
        $_SESSION['flash_error'] = 'Заполните все поля';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    if (strlen($password) < 4) {
        $_SESSION['flash_error'] = 'Пароль должен быть не менее 4 символов';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
    if ($password != $passwordConfirm) {
        $_SESSION['flash_error'] = 'Пароли не совпадают';
        $_SESSION['old_login'] = $login;
        header('Location: register.controller.php');
        exit();
    }
    
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