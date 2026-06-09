<?php
define('APP_LOADED', true);

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../controllers/login.controller.php');
    exit();
}

if ($_SESSION['user']['role'] !== 'admin') {
    $_SESSION['flash_error'] = 'Доступ запрещён. Только для администраторов.';
    header('Location: ../index.php');
    exit();
}

require_once '../db/connectDB.php';
require_once '../models/logs.model.php';

$logs = getLogs($pdo);

include '../views/logs.view.php';
