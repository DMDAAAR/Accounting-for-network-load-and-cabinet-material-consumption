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

require_once '../db/connectDB.php';
require_once '../models/defects.model.php';
require_once '../models/inventory.model.php';
require_once '../models/materials.model.php';
require_once '../models/logs.model.php';

$userId = $_SESSION['user']['id'];

// --- Функция для создания папки и получения пути для сохранения ---
function getUploadPath($relativePath = 'uploads/defects/') {
    $projectRoot = dirname(__DIR__);
    $fullPath = $projectRoot . '/' . ltrim($relativePath, '/');
    if (!is_dir($fullPath)) {
        if (!mkdir($fullPath, 0755, true)) {
            $_SESSION['flash_error'] = "Не удалось создать папку: $relativePath. Пожалуйста, создайте её вручную.";
            return false;
        }
    }
    if (!is_writable($fullPath)) {
        $_SESSION['flash_error'] = "Папка $relativePath недоступна для записи. Установите права на запись.";
        return false;
    }
    return $fullPath;
}

// --- Обработка POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Починка
    if (isset($_POST['fix_submit']) && isset($_POST['fix_id'])) {
        $defect_id = (int)$_POST['fix_id'];
        $defect = getDefectById($pdo, $defect_id);
        if (!$defect) {
            $_SESSION['flash_error'] = "Дефект не найден";
            header('Location: defects.controller.php');
            exit();
        }

        $material_ids = $_POST['material_id'] ?? [];
        $quantities   = $_POST['quantity'] ?? [];
        $errors = [];

        foreach ($material_ids as $index => $material_id) {
            $quantity = floatval($quantities[$index] ?? 0);
            if ($material_id && $quantity > 0) {
                $result = useMaterialsForDefect($pdo, $material_id, $quantity, $defect_id, $userId);
                if (!$result) {
                    $errors[] = "Не удалось списать материал ID $material_id";
                }
            }
        }

        if (empty($errors)) {
            fixDefect($pdo, $defect_id);
            addLog($pdo, $userId, "Починил дефект #$defect_id", 'defects', $defect_id);
            $_SESSION['flash_success'] = "Дефект #$defect_id починен!";
            header('Location: defects.controller.php');
            exit();
        } else {
            $_SESSION['flash_error'] = implode('<br>', $errors);
            header("Location: defects.controller.php?fix_id=$defect_id");
            exit();
        }
    }

    // 2. Удаление (удаляем также файл фото)
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_id'])) {
        $defect_id = (int)$_POST['delete_id'];
        $defect = getDefectById($pdo, $defect_id);
        if ($defect && !empty($defect['photo_path'])) {
            $filePath = dirname(__DIR__) . '/' . ltrim(str_replace(BASE_URL, '', $defect['photo_path']), '/');
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        if (deleteDefect($pdo, $defect_id)) {
            addLog($pdo, $userId, "Удалил дефект #$defect_id", 'defects', $defect_id);
            $_SESSION['flash_success'] = "Дефект #$defect_id удалён";
        } else {
            $_SESSION['flash_error'] = "Ошибка при удалении";
        }
        header('Location: defects.controller.php');
        exit();
    }

    // 3. Добавление / редактирование
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $point_id    = (int)($_POST['point_id'] ?? 1);
    $status      = $_POST['status'] ?? 'open';
    $category    = $_POST['category'] ?? 'other';
    $severity    = $_POST['severity'] ?? 'medium';

    $photo_path = null;
    $uploadError = false;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = getUploadPath('uploads/defects/');
        if (!$uploadDir) {
            header('Location: defects.controller.php');
            exit();
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['photo']['tmp_name']);
        finfo_close($finfo);
        $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($mime, $allowedMime)) {
            $_SESSION['flash_error'] = 'Разрешены только JPEG, PNG, GIF, WEBP';
            $uploadError = true;
        }
        if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
            $_SESSION['flash_error'] = 'Файл не более 2 МБ';
            $uploadError = true;
        }

        if (!$uploadError) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $filename = 'defect_' . uniqid() . '.' . $ext;
            $destination = $uploadDir . '/' . $filename;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                $photo_path = BASE_URL . 'uploads/defects/' . $filename;
            } else {
                $_SESSION['flash_error'] = 'Ошибка при сохранении файла';
                $uploadError = true;
            }
        }

        if ($uploadError) {
            if (isset($_POST['id'])) {
                header("Location: defects.controller.php?edit_id=" . $_POST['id']);
            } else {
                header("Location: defects.controller.php");
            }
            exit();
        }
    }

    // Валидация полей
    $error = null;
    if (empty($title)) $error = "Укажите название поломки";
    elseif (empty($description)) $error = "Опишите проблему";
    elseif (!in_array($status, ['open', 'in_progress', 'closed'])) $error = "Некорректный статус";
    elseif (!in_array($category, ['network', 'power', 'hardware', 'other'])) $error = "Некорректная категория";
    elseif (!in_array($severity, ['low', 'medium', 'high'])) $error = "Некорректная критичность";

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        if ($error === null) {
            if ($photo_path === null) {
                $old = getDefectById($pdo, $id);
                $photo_path = $old['photo_path'];
            } else {
                $old = getDefectById($pdo, $id);
                if ($old && !empty($old['photo_path'])) {
                    $oldFile = dirname(__DIR__) . '/' . ltrim(str_replace(BASE_URL, '', $old['photo_path']), '/');
                    if (file_exists($oldFile)) unlink($oldFile);
                }
            }
            if (updateDefect($pdo, $id, $title, $description, $point_id, $status, $photo_path, $category, $severity)) {
                addLog($pdo, $userId, "Обновил дефект #$id", 'defects', $id);
                $_SESSION['flash_success'] = "Дефект #$id обновлён";
            } else {
                $_SESSION['flash_error'] = "Ошибка при обновлении";
            }
        } else {
            $_SESSION['flash_error'] = $error;
        }
    } else {
        if ($error === null) {
            if (addDefect($pdo, $title, $description, $point_id, $userId, $photo_path, $category, $severity)) {
                addLog($pdo, $userId, "Добавил новый дефект", 'defects', 0);
                $_SESSION['flash_success'] = "Дефект добавлен!";
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

// --- GET ---
if (isset($_GET['fix_id'])) {
    $defect_id = (int)$_GET['fix_id'];
    $defect = getDefectById($pdo, $defect_id);
    if (!$defect) {
        $_SESSION['flash_error'] = "Дефект не найден";
        header('Location: defects.controller.php');
        exit();
    }
    $materials = getAllMaterials($pdo);
    include '../views/fix_defect.view.php';
    exit();
}

$editableDefect = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    if ($edit_id > 0) $editableDefect = getDefectById($pdo, $edit_id);
}
$defects = getDefects($pdo);
foreach ($defects as &$defect) {
    $defect['used_materials'] = getMaterialsUsedForDefect($pdo, $defect['id']);
}
$networkPoints = getStatsPoints($pdo);
include '../views/defects.view.php';
exit();