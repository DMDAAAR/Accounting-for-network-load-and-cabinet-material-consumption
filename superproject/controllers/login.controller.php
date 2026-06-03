<?php
// Защита от прямого вызова
define('APP_LOADED', true);

session_start();

// Проверка залогинен пользователь
if (isset($_SESSION['user'])) {
    header('Location: dashboard.controller.php');
    exit();
}

require_once '../connectDB.php';
require_once '../models/user.models.php';
// запрос -показать форму входа
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include '../views/login.view.php';
    exit();
}

// запрос - пользователь отправил форму
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    //  логин из формы
    if (isset($_POST['login'])) {
        $login = $_POST['login'];
    } else {
        $login = '';
    }
    
    // пароль из формы
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }
    
    // Проверка: поля не должны быть пустыми
    if ($login == '' || $password == '') {
        $_SESSION['flash_error'] = 'Заполните все поля';
        header('Location: login.controller.php');
        exit();
    }
    
    // поиск в бд
    $user = getUserByUsername($pdo, $login);
    
    // Если нету
    if ($user == false) {
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        header('Location: login.controller.php');
        exit();
    }
    
    // Проверка пароя
    $passwordIsCorrect = password_verify($password, $user['password_hash']);
    
    if ($passwordIsCorrect == true) {
        
        session_regenerate_id(true);
        
        // Сохранение данных пользователя в сессию
        $_SESSION['user'] = [
            'id' => $user['id'],
            'login' => $user['login'],
            'role' => $user['role']
        ];
        
        header('Location: dashboard.controller.php');
        exit();
        
    } else {
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        header('Location: login.controller.php');
        exit();
    }
}
?>