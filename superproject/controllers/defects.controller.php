<?php
define('APP_LOADED', true);

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}

require_once __DIR__ . '/../db/connectDB.php';
require_once __DIR__ . '/../models/defects.model.php';

$userId = $_SESSION['user']['id'];

// Обработка POST (добавление и редактирование)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Редактирование
    if (isset($_POST['edit_id'])) {
        $defect_id = (int)$_POST['edit_id'];
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'open';

        if ($description === '') {
            $_SESSION['flash_error'] = 'Описание не может быть пустым';
            header('Location: defects.controller.php?edit_id=' . $defect_id);
            exit();
        }

        $stmt = $pdo->prepare("UPDATE defects SET description = :description, status = :status WHERE id = :defect_id");
        $stmt->execute([':description' => $description, ':status' => $status, ':defect_id' => $defect_id]);

        $_SESSION['flash_success'] = 'Дефект изменён';
        header('Location: defects.controller.php');
        exit();
    }

    // Добавление нового дефекта
    if (isset($_POST['description'])) {
        $description = trim($_POST['description']);

        if ($description === '') {
            $_SESSION['flash_error'] = 'Опишите проблему!';
            header('Location: defects.controller.php');
            exit();
        }

        $pointId = 1; // временно, потом можно сделать выбор
        $category = 'other';
        $severity = 'medium';
        $photoPath = null;

        $result = addDefect($pdo, $pointId, $category, $severity, $description, $photoPath, $userId);
        if ($result !== false) {
            $_SESSION['flash_success'] = 'Дефект успешно добавлен!';
        } else {
            $_SESSION['flash_error'] = 'Ошибка при добавлении дефекта';
        }
        header('Location: defects.controller.php');
        exit();
    }
}

// Удаление через GET (но лучше переделать на POST, оставим для совместимости, но добавим предупреждение)
if (isset($_GET['delete_id'])) {
    $defect_id = (int)$_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM defects WHERE id = ?");
    if ($stmt->execute([$defect_id])) {
        $_SESSION['flash_success'] = 'Дефект #' . $defect_id . ' удалён';
    } else {
        $_SESSION['flash_error'] = 'Ошибка при удалении';
    }
    header('Location: defects.controller.php');
    exit();
}

// GET: показываем список, возможно с формой редактирования
$defects = getDefects($pdo);
$editDefect = null;
if (isset($_GET['edit_id'])) {
    $editId = (int)$_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM defects WHERE id = ?");
    $stmt->execute([$editId]);
    $editDefect = $stmt->fetch(PDO::FETCH_ASSOC);
}
include __DIR__ . '/../views/defects.view.php';