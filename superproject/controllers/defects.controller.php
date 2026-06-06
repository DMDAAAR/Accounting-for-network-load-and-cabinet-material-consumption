<?php
define('APP_LOADED', true);
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
session_start();

// Проверка авторизации
if (!isset($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}

require_once '../db/connectDB.php';
require_once '../models/defects.model.php';
require_once '../models/inventory.model.php'; // для getStatsPoints()
require_once '../models/logs.model.php';

$userId = $_SESSION['user']['id'];

// --- ОБРАБОТКА POST-ЗАПРОСОВ (удаление, добавление, обновление) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Удаление
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_id'])) {
        $defect_id = (int)$_POST['delete_id'];
        if (deleteDefect($pdo, $defect_id)) {
            $_SESSION['flash_success'] = "Дефект #$defect_id удалён";
            addLog($pdo, $userId, 'Удалён д...', '', 0);
        } else {
            $_SESSION['flash_error'] = "Ошибка при удалении";
        }
        header('Location: defects.controller.php');
        exit();
    }

    // 2. Добавление или обновление (определяем по наличию скрытого поля 'id')
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $point_id    = (int)($_POST['point_id'] ?? 1);
    $status      = $_POST['status'] ?? 'open';

    // Валидация
    $error = null;
    if (empty($title)) {
        $error = "Укажите название поломки";
    } elseif (empty($description)) {
        $error = "Опишите проблему";
    } elseif (!in_array($status, ['open', 'in_progress', 'closed'])) {
        $error = "Некорректный статус";
    }

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Режим РЕДАКТИРОВАНИЯ
        $id = (int)$_POST['id'];
        if ($error === null) {
            if (updateDefect($pdo, $id, $title, $description, $point_id, $status)) {
                $_SESSION['flash_success'] = "Дефект #$id обновлён";
                addLog($pdo, $userId, "Обновлён дефект #$id");
            } else {
                $_SESSION['flash_error'] = "Ошибка при обновлении";
            }
        } else {
            $_SESSION['flash_error'] = $error;
        }
    } else {
        // Режим ДОБАВЛЕНИЯ
        if ($error === null) {
            if (addDefect($pdo, $title, $description, $point_id, $userId)) {
                $_SESSION['flash_success'] = "Дефект успешно добавлен!";
                addLog($pdo, $userId, "Добавлен дефект");
            } else {
                $_SESSION['flash_error'] = "Ошибка при добавлении";
            }
        } else {
            $_SESSION['flash_error'] = $error;
        }
    }

    header('Location: defects.controller.php');
    exit();
}

// --- ОБРАБОТКА GET-ЗАПРОСОВ (показ формы, возможно с edit_id) ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $editableDefect = null;
    if (isset($_GET['edit_id'])) {
        $edit_id = (int)$_GET['edit_id'];
        if ($edit_id > 0) {
            $editableDefect = getDefectById($pdo, $edit_id);
        }
    }

    $defects       = getDefects($pdo);
    $networkPoints = getStatsPoints($pdo); // список точек сети для выпадающего списка

    include '../views/defects.view.php';
    exit();
}
