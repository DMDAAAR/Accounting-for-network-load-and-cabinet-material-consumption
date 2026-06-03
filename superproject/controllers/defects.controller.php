<?php
define('APP_LOADED', true);

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}

require_once '../connectDB.php';

require_once '../models/defects.model.php';

$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['description'])) {
        $description = trim($_POST['description']);
    } else {
        $description = '';
    }
    
    if ($description == '') {
        $_SESSION['flash_error'] = 'Опишите проблему!';
        header('Location: defects.controller.php');
        exit();
    }

    $pointId = 1;         
    $category = 'other';
    $severity = 'medium';
    $photoPath = NULL; 
    
    $result = addDefect($pdo, $pointId, $category, $severity, $description, $photoPath, $userId);
    if ($result != false) {
        $_SESSION['flash_success'] = 'Дефект успешно добавлен!';
    } else {
        $_SESSION['flash_error'] = 'Ошибка при добавлении дефекта';
    }
    header('Location: defects.controller.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $defects = getDefects($pdo);
    include '../views/defects.view.php';
    exit();
}