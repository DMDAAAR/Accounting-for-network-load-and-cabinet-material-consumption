<?php
$page = $page ?? 1;
require './models/logs.model.php';
include __DIR__ . '/components/header.view.php';
?>

<div class="container-fluid mt-4">
    <h2 class="mb-3">Точки сети</h2>
    <div class="mb-4">
        <form action="" method="get" class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Поиск по точкам..." value="<?= htmlspecialchars($search ?? '') ?>">
            <button class="btn btn-salad" type="submit">
                <i class="bi bi-search"></i> Поиск
            </button>
        </form>
    </div>

    <?php if (!empty($data)): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Метка</th>
                                <th>Тип</th>
                                <th>Статус</th>
                                <th>Последняя проверка</th>
                                <th>Расположение</th>
                                <th>Конечная точка</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['label']) ?></td>
                                    <td><?= htmlspecialchars($row['type']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <td><?= htmlspecialchars($row['last_check']) ?></td>
                                    <td><?= htmlspecialchars($row['location_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['location_end_name'] ?? '') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <nav aria-label="Page navigation" class="mb-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= ($page > 1) ? "?page=".($page - 1)."&search=".urlencode($search ?? '') : "javascript:void(0)" ?>">«</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= ($page < $totalPages) ? "?page=".($page + 1)."&search=".urlencode($search ?? '') : "javascript:void(0)" ?>">»</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info mt-4 mb-5">Точки сети не найдены.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include __DIR__ . '/components/footer.view.php'; ?>
