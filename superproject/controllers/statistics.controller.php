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
require_once '../models/statistics.model.php';

$totalComputers = getTotalComputers($pdo);
$networkStats = getNetworkPointsStats($pdo);
$materialsStats = getMaterialsStats($pdo);
$switchPorts = getSwitchPortsData($pdo);

// Подготовка данных для круговых диаграмм
$pieNetworkData = [
    'active' => ['value' => $networkStats['active'], 'color' => '#28a745', 'label' => 'Активно'],
    'defect' => ['value' => $networkStats['defect'], 'color' => '#dc3545', 'label' => 'Дефект'],
    'decommissioned' => ['value' => $networkStats['decommissioned'], 'color' => '#6c757d', 'label' => 'Списано']
];
$totalNetwork = array_sum(array_column($pieNetworkData, 'value'));
$networkAngles = [];
$start = 0;
foreach ($pieNetworkData as $key => $item) {
    $percent = $totalNetwork > 0 ? ($item['value'] / $totalNetwork) : 0;
    $angle = $percent * 360;
    $networkAngles[$key] = [
        'start' => $start,
        'end' => $start + $angle,
        'color' => $item['color'],
        'label' => $item['label'],
        'value' => $item['value']
    ];
    $start += $angle;
}

$pieMaterialData = [
    'cable' => ['value' => $materialsStats['cable'], 'color' => '#17a2b8', 'label' => 'Кабель (м)'],
    'connector' => ['value' => $materialsStats['connector'], 'color' => '#ffc107', 'label' => 'Коннекторы (шт)'],
    'socket' => ['value' => $materialsStats['socket'], 'color' => '#6610f2', 'label' => 'Розетки (шт)']
];
$totalMaterial = array_sum(array_column($pieMaterialData, 'value'));
$materialAngles = [];
$start = 0;
foreach ($pieMaterialData as $key => $item) {
    $percent = $totalMaterial > 0 ? ($item['value'] / $totalMaterial) : 0;
    $angle = $percent * 360;
    $materialAngles[$key] = [
        'start' => $start,
        'end' => $start + $angle,
        'color' => $item['color'],
        'label' => $item['label'],
        'value' => $item['value']
    ];
    $start += $angle;
}

include '../views/statistics.view.php';