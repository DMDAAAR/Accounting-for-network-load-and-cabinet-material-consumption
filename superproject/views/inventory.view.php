<?php 
include __DIR__ . '/components/header.view.php'; 
?>
<div class="container-fluid mt-4">
    <h2>Оборудование и материалы</h2>

    <h4>Точки сети</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Метка</th>
                <th>Тип</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
        <?php if (isset($points) && is_array($points)): ?>
            <?php foreach ($points as $point): ?>
                <tr>
                    <td><?php echo $point['id']; ?></td>
                    <td><?php echo htmlspecialchars($point['label']); ?></td>
                    <td><?php echo htmlspecialchars($point['type']); ?></td>
                    <td><?php echo htmlspecialchars($point['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center text-muted">Данные о точках сети не переданы из контроллера</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    </div>

<?php 
include __DIR__ . '/components/footer.view.php'; 
?>
