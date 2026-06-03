<?php
require '../db/connectDB.php';
require '../models/materials.model.php';
useMaterials($pdo, $material_id, $quantity);
