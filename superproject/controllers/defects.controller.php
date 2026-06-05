<?php
define('APP_LOADED', true);
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}

require_once '../db/connectdb.php';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
    $defect_id = $_POST['edit_id'];
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    if ($description == '') {
        $_SESSION['flash_error'] = 'Описание не может быть пустым';
        header('Location: defects.controller.php?edit_id=' . $defect_id);
        exit();
    }

    $stmt = $pdo->prepare("UPDATE defects SET description = :description, status = :status WHERE id = :defect_id");
    $stmt->execute([$description, $status, $defect_id]);

    $_SESSION['flash_success'] = 'Дефект изменен';
    header('Location: defects.controller.php');
    exit();
}

if (isset($_GET['delete_id'])) {
    $defect_id = (int)$_GET['delete_id'];

    $stmt = $pdo->prepare("DELETE FROM defects WHERE id = ?");
    $result = $stmt->execute([$defect_id]);

    if ($result) {
        $_SESSION['flash_success'] = 'Дефект #' . $defect_id . ' удален';
    } else {
        $_SESSION['flash_error'] = 'Ошибка при удалении';
    }

    header('Location: defects.controller.php');
    exit();
}
