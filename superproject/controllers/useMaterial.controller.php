<?php
require '../db/connectDB.php';
require '../models/materials.model.php';
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
$material_id = $_POST['material_id'];
$quantity = $_POST['quantity'];
useMaterials($pdo, $material_id, $quantity);
header("Location: ../views/materials.view.php");
