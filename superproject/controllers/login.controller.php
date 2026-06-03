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
    
   // проверка1
    if ($login == '' || $password == '') {
        $_SESSION['flash_error'] = 'Заполните все поля';
        $_SESSION['old_login'] = $login;
        header('Location: login.controller.php');
        exit();
    }
    
    // проверка2
    if (strlen($login) > 50) {
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        $_SESSION['old_login'] = $login;
        header('Location: login.controller.php');
        exit();
    }
    
    // проверка3
    if (strlen($password) > 100) {
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        $_SESSION['old_login'] = $login;
        header('Location: login.controller.php');
        exit();
    }
    
    // проверка4
    if (strlen($login) > 255 || strlen($password) > 255) {
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        $_SESSION['old_login'] = $login;
        header('Location: login.controller.php');
        exit();
    }
    
    // проверка5
    $dangerousChars = [';', '--', '/*', '*/', 'xp_', 'exec', 'union', 'select'];
    $loginLower = strtolower($login);
    foreach ($dangerousChars as $char) {
        if (strpos($loginLower, $char) !== false) {
            $_SESSION['flash_error'] = 'Неверный логин или пароль';
            $_SESSION['old_login'] = $login;
            header('Location: login.controller.php');
            exit();
        }
    }
    
    // проверка6
    $loginSafe = htmlspecialchars($login, ENT_QUOTES, 'UTF-8');
    if ($loginSafe != $login) {
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        $_SESSION['old_login'] = $login;
        header('Location: login.controller.php');
        exit();
    }
    
    // проверка7
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $attemptKey = 'login_attempts_' . md5($ip);
    
    if (!isset($_SESSION[$attemptKey])) {
        $_SESSION[$attemptKey] = 0;
    }
    
    if ($_SESSION[$attemptKey] >= 5) {
        $_SESSION['flash_error'] = 'Слишком много попыток входа. Попробуйте позже.';
        header('Location: login.controller.php');
        exit();
    }
    
    $user = getUserByUsername($pdo, $login);
    
    // проверка8
    if ($user == false) {
        $_SESSION[$attemptKey] = $_SESSION[$attemptKey] + 1; 
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        $_SESSION['old_login'] = $login;
        header('Location: login.controller.php');
        exit();
    }
    
    // проверка9
    $passwordIsCorrect = password_verify($password, $user['password_hash']);
    
    if ($passwordIsCorrect == true) {
        
        unset($_SESSION[$attemptKey]);
        
        session_regenerate_id(true);
       
        $_SESSION['user'] = [
            'id' => $user['id'],
            'login' => $user['login'],
            'role' => $user['role']
        ];
        
       
        $_SESSION['login_time'] = time();
        
     
        $logSql = "INSERT INTO logs (user_id, action, target_table, target_id) VALUES (:user_id, 'Вход в систему', 'users', :user_id)";
        $logStmt = $pdo->prepare($logSql);
        $logStmt->execute([':user_id' => $user['id']]);
        
        header('Location: dashboard.controller.php');
        exit();
        
    } else {
      
        $_SESSION[$attemptKey] = $_SESSION[$attemptKey] + 1; 
        $_SESSION['flash_error'] = 'Неверный логин или пароль';
        $_SESSION['old_login'] = $login;
        header('Location: login.controller.php');
        exit();
    }
}
