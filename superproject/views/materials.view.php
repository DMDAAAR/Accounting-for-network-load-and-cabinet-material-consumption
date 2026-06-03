<?php
require '../models/materials.model.php';
require "../db/connectDB.php";
$materials = getMaterials($pdo);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список материалов</title>
    <style>
        .consume-form {
            display: inline-block;
            margin-left: 15px;
            vertical-align: middle;
        }
        .consume-form input[type="number"] {
            width: 60px;
            padding: 3px;
            margin-right: 5px;
        }
        .consume-form button {
            padding: 3px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Список материалов</h2>
    <ul>
        <?php foreach ($materials as $material): ?>
            <li style="margin-bottom: 8px;">
                <strong>ID:</strong> <?= htmlspecialchars($material['id']) ?>
                <strong>Название:</strong> <?= htmlspecialchars($material['name']) ?>
                <strong>Тип:</strong> <?= htmlspecialchars($material['type']) ?>
                <strong>Количество:</strong> <?= htmlspecialchars($material['quantity']) ?> <?= htmlspecialchars($material['unit']) ?>
                <strong>Остаток:</strong> <?= htmlspecialchars($material['quantity']) ?>
                <!-- Форма для списания -->
                <form class="consume-form" method="GET" action="#">
                    <input type="hidden" name="action" value="consume">
                    <input type="hidden" name="material_id" value="<?= $material['id'] ?>">
                    <input type="number" name="quantity" min="0" step="1" value="1" required>
                    <button type="submit">Списать</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="#">Вернуться на главную страницу</a>
</body>
</html>
