<?php

require_once '../db/connectDB.php';
require_once '../models/materials.model.php';
if (!defined('BASE_URL')) {
    define('BASE_URL', '/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['id'])) {
    global $pdo;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $material_id = filter_input(INPUT_POST, 'material_id', FILTER_VALIDATE_INT);
    } else {
        $material_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    }
    
    if ($material_id && $material_id > 0) {
        deleteMaterial($pdo, $material_id);
    }
}

header("Location: ../views/materials.view.php");
exit;
?>