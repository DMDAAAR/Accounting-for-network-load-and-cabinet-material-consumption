<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=record_keeping;", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Критическая ошибка подключения к БД: " . $e->getMessage());
}