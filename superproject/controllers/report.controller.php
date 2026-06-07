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
require_once '../models/report.model.php';

$date_from  = isset($_GET['date_from']) ? trim($_GET['date_from']) : '';
$date_to    = isset($_GET['date_to']) ? trim($_GET['date_to']) : '';
$category   = isset($_GET['category']) ? trim($_GET['category']) : 'all';
$point_type = isset($_GET['point_type']) ? trim($_GET['point_type']) : 'all';
$status     = isset($_GET['status']) ? trim($_GET['status']) : 'all';

$records = getFilteredDefects($pdo, $date_from, $date_to, $category, $point_type, $status);

$categoriesList = getUniqueDefectCategories($pdo);

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    if (ob_get_level()) {
        ob_end_clean();
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="defects_report_' . date('Y-m-d_H-i-s') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $df = fopen('php://output', 'w');

    fprintf($df, chr(0xEF).chr(0xBB).chr(0xBF));

    fputcsv($df, [
        'ID дефекта',
        'Название дефекта',
        'Раздел (Категория)',
        'Важность',
        'Описание',
        'Статус',
        'Сетевая точка',
        'Тип точки',
        'Аудитория',
        'Кем создан',
        'Дата создания'
    ], ';');

    foreach ($records as $row) {
        $statusText = 'Открыт';
        if ($row['status'] === 'in_progress') $statusText = 'В работе';
        if ($row['status'] === 'closed') $statusText = 'Закрыт';

        $severityText = 'Средняя';
        if ($row['severity'] === 'high') $severityText = 'Высокая';
        if ($row['severity'] === 'low') $severityText = 'Низкая';

        fputcsv($df, [
            $row['id'],
            $row['title'],
            $row['category'],
            $severityText,
            $row['description'],
            $statusText,
            $row['point_label'] ?? '—',
            $row['point_type'] ?? '—',
            $row['location_name'] ?? '—',
            $row['creator_login'] ?? '—',
            date('d.m.Y H:i', strtotime($row['created_at']))
        ], ';');
    }

    fclose($df);
    exit();
}

include '../views/report.view.php';
