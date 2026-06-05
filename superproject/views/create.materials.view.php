<?php
require_once '../db/connectDB.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить материал</title>
    <style>
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>Добавить новый материал</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="error">Ошибка: <?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="../controllers/create.material.controller.php">
        <p>
            <label>Название: </label>
            <input type="text" name="name" required maxlength="100">
        </p>
        <p>
            <label>Тип: </label>
            <select name="type" required>
                <option value="">Выберите тип</option>
                <option value="cable">Кабель (cable)</option>
                <option value="connector">Коннектор (connector)</option>
                <option value="socket">Розетка (socket)</option>
                <option value="fastener">Крепеж (fastener)</option>
            </select>
        </p>
        <p>
            <label>Единица измерения: </label>
            <select name="unit" required>
                <option value="">Выберите единицу</option>
                <option value="m">Метры (m)</option>
                <option value="pcs">Штуки (pcs)</option>
            </select>
        </p>
        <p>
            <label>Количество: </label>
            <input type="number" name="quantity" min="0" step="0.01" value="0" required>
        </p>
        
        <button type="submit">Добавить</button>
    </form>

    <br>
    <a href="../views/materials.view.php">Назад к списку</a>

</body>
</html>