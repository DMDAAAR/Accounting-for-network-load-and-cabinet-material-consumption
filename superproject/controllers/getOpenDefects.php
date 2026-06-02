<?php
require 'connectBD.php';
require 'models/models.php';
$OpenDefens = getOpenDefects($pdo);
include 'index.php';
