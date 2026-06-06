<?php
define('APP_LOADED', true);
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
session_start();

// if (isset($_SESSION['user'])) {
//     header('Location: ../index.php');
//     exit();
// }

require '../db/connectDB.php';
require '../models/user.model.php';
require '../models/logs.model.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include '../views/login.view.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])) {
        $login = $_POST['login'];
    } else {
        $login = '';
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }

    if ($login == '' || $password == '') {
        $_SESSION['flash_error'] = 'Заполните все поля';
        header('Location: login.controller.php');
        exit();
    }

    $user = getUserByUsername($pdo, $login);

    if ($user == false) {
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        header('Location: login.controller.php');
        exit();
    }

    $passwordIsCorrect = password_verify($password, $user['password_hash']);

    if ($passwordIsCorrect == true) {
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'login' => $user['login'],
            'role' => $user['role']
        ];
        addLog($pdo, '1', 'Вошёл в систему', '', 0);

        exit(header('Location: ../index.php'));
    } else {
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        header('Location: login.controller.php');
        exit();
    }
}
?>
