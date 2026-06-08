<?php
define('APP_LOADED', true);
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}

require_once '../db/connectDB.php';
require_once '../models/report.model.php';

$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$point_type = isset($_GET['point_type']) ? $_GET['point_type'] : 'all';
$status = isset($_GET['status']) ? $_GET['status'] : 'all';

$records = getFilteredDefects($pdo, $date_from, $date_to, $category, $point_type, $status);
$categoriesList = getUniqueDefectCategories($pdo);

if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="report.csv"');
    echo "\xEF\xBB\xBF"; 
    echo "ID;Название;Категория;Критичность;Описание;Статус;Точка;Тип;ПК;Создал;Дата\n";
    
    foreach ($records as $row) {
        $p_label = isset($row['point_label']) ? $row['point_label'] : '—';
        $p_type = isset($row['point_type']) ? $row['point_type'] : '—';
        $loc_name = isset($row['location_name']) ? $row['location_name'] : '—';
        $creator = isset($row['creator_login']) ? $row['creator_login'] : '—';
        
        echo $row['id'] . ";" . 
             $row['title'] . ";" . 
             $row['category'] . ";" . 
             $row['severity'] . ";" . 
             $row['description'] . ";" . 
             $row['status'] . ";" . 
             $p_label . ";" . 
             $p_type . ";" . 
             $loc_name . ";" . 
             $creator . ";" . 
             $row['created_at'] . "\n";
    }
    exit();
}

include '../views/report.view.php';