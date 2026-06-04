<?php
require_once '../db/connectDB.php';
require_once '../models/materials.model.php';

global $pdo;

$material_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$material_id) {
    header("Location: ../views/materials.view.php");
    exit;
}

$sql = "SELECT * FROM materials WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $material_id]);
$material = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$material) {
    header("Location: ../views/materials.view.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать материал</title>
</head>
<body>

    <h2>Редактировать материал</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;">Ошибка: <?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form method="POST" action="../controllers/update.material.controller.php">
        <input type="hidden" name="id" value="<?= $material['id'] ?>">
        
        <p>
            <label>Название:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($material['name']) ?>" required maxlength="100">
        </p>
        
        <p>
            <label>Тип:</label>
            <select name="type" required>
                <option value="cable" <?= $material['type'] == 'cable' ? 'selected' : '' ?>>Кабель (cable)</option>
                <option value="connector" <?= $material['type'] == 'connector' ? 'selected' : '' ?>>Коннектор (connector)</option>
                <option value="socket" <?= $material['type'] == 'socket' ? 'selected' : '' ?>>Розетка (socket)</option>
                <option value="fastener" <?= $material['type'] == 'fastener' ? 'selected' : '' ?>>Крепеж (fastener)</option>
            </select>
        </p>
        
        <p>
            <label>Единица измерения:</label>
            <select name="unit" required>
                <option value="m" <?= $material['unit'] == 'm' ? 'selected' : '' ?>>Метры (m)</option>
                <option value="pcs" <?= $material['unit'] == 'pcs' ? 'selected' : '' ?>>Штуки (pcs)</option>
            </select>
        </p>
        
        <p>
            <label>Количество:</label>
            <input type="number" name="quantity" min="0" step="0.01" value="<?= $material['quantity'] ?>" required>
        </p>
        
        <button type="submit">Сохранить</button>
        <a href="../views/materials.view.php">Отмена</a>
    </form>

</body>
</html>