<?php include 'components/header.view.php'; ?>

<div class="container-fluid mt-4">
    <h2>Оборудование и материалы</h2>

    <!-- Пример вывода точек сети -->
    <h4>Точки сети</h4>
    <table class="table table-striped">
        <thead>
        <tr><th>ID</th><th>Метка</th><th>Тип</th><th>Статус</th></tr>
        </thead>
        <tbody>
        <?php foreach ($points as $point): ?>
            <tr>
                <td><?= $point['id'] ?></td>
                <td><?= htmlspecialchars($point['label']) ?></td>
                <td><?= $point['type'] ?></td>
                <td><?= $point['status'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Здесь можно вывести материалы, дефекты и т.д. -->
</div>

<?php include __DIR__ . '/components/footer.view.php'; ?>
