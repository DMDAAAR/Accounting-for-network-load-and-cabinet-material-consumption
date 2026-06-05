<?php
require '../db/connectDB.php';
require '../models/materials.model.php';
$materials = getMaterials($pdo);

