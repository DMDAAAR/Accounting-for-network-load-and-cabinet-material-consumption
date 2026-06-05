<?php
require '../db/connectDB.php';
require '../models/materials.model.php';
$materials = getMaterials($pdo);
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
