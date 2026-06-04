<?php
require '../controllers/materials.controller.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список материалов</title>

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
                <form class="consume-form" method="POST" action="../controllers/useMaterial.controller.php">
                    <input type="hidden" name="material_id" value="<?= $material['id'] ?>">
                    <input type="number" name="quantity" min="0" step="1" value="1" required>
                    <button type="submit">Списать</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="../views/index.view.php">Вернуться на главную страницу</a>
</body>
</html>
