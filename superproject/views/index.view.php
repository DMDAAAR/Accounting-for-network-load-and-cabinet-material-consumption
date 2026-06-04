<?php include __DIR__ . '/components/header.view.php'; ?>

<div class="container-fluid mt-4">
    <h2 class="mb-3">Точки сети</h2>
            <style>

.btn-salad {
    background-color: #90EE90;
    border-color: #90EE90;
    color: #333;
}
.btn-salad:hover {
    background-color: #7CFC00;
    border-color: #7CFC00;
}


.pagination .page-link {
    color: #333;
}
.pagination .page-item.active .page-link {
    background-color: #90EE90;
    border-color: #90EE90;
}
.pagination .page-item.active .page-link:hover {
    background-color: #7CFC00;
}

/* Стилизация таблицы */
.table-borderless th,
.table-borderless td,
.table-borderless thead th {
    border: 1px solid rgba(0,0,0,.05);
}
.table-hover tbody tr:hover {
    background-color: rgba(90, 255, 90, 0.2);
}

/* Карточка таблицы (белый фон) */
.card-body {
    background-color: #fff;
}
        </style>
    <!-- Блок поиска -->
    <div class="mb-4">
        <form action="" method="get" class="input-group">
            <input type="text" name="search" class="form-control"
                   placeholder="Поиск по точкам..."
                   value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-salad" type="submit">
                <i class="bi bi-search"></i> Поиск
            </button>
        </form>
    </div>

    <?php if (!empty($data)): ?>
        <!-- Блок таблицы -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle">
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

        <!-- Блок пагинации -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation" class="mb-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= ($page > 1) ? "?page=".($page - 1)."&search=".urlencode($search) : "javascript:void(0)" ?>">«</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= ($page < $totalPages) ? "?page=".($page + 1)."&search=".urlencode($search) : "javascript:void(0)" ?>">»</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>


    <?php else: ?>
        <div class="alert alert-info mt-4">Точки сети не найдены.</div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/components/footer.view.php'; ?>
