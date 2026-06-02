<?php
require 'connectBD.php';
require 'models/models.php';
$DefectById = getDefectById($pdo, $_GET);
include 'index.php';
