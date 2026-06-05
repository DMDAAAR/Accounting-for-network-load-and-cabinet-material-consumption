<?php
require '../controllers/materials.controller.php';

include __DIR__ . '/components/header.view.php';

?>
<!DOCTYPE html>
<lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список материалов</title>
    <!-- Подключение Bootstrap CSS (если еще не подключено) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h2>Список материалов</h2>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Тип</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Остаток</th>
                    <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materials as $material): ?>
                    <tr data-id="<?= htmlspecialchars($material['id']) ?>">
                        <td><?= htmlspecialchars($material['id']) ?></td>
                        <td><?= htmlspecialchars($material['name']) ?></td>
                        <td><?= htmlspecialchars($material['type']) ?></td>
                        <td><?= htmlspecialchars($material['quantity']) ?> <?= htmlspecialchars($material['unit']) ?></td>
                        <td><?= htmlspecialchars($material['quantity']) ?> <?= htmlspecialchars($material['unit']) ?></td>
                        <td class="text-center">
                            <!-- Компактная форма списания -->
                            <form class="d-inline" method="POST" action="../controllers/useMaterial.controller.php">
                                <input type="hidden" name="material_id" value="<?= htmlspecialchars($material['id']) ?>">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="number" name="quantity" min="0" step="<?= $material['unit'] === 'шт' ? 1 : 1 ?>" value="<?= $material['unit'] === 'шт' ? 1 : 1 ?>" required
                                           class="form-control form-control-sm text-center" style="max-width: 60px;">
                                    <button type="submit" class="btn btn-success btn-sm" style="background-color: #98D98C; border-color: #98D98C;">
                                        Списать
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Подключение Bootstrap JS и Popper (опционально, для работы некоторых компонентов) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include __DIR__ . '/components/footer.view.php'; ?>
</html>
