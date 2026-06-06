<?php 
$page = $page ?? 1; 

include __DIR__ . '/components/header.view.php'; 
?>

<div class="container-fluid mt-4">
    <h2 class="mb-3">Точки сети</h2>
    <style>
        .btn-salad { background-color: #90EE90; border-color: #90EE90; color: #333; }
        .btn-salad:hover { background-color: #7CFC00; border-color: #7CFC00; }
        .pagination .page-link { color: #333; }
        .pagination .page-item.active .page-link { background-color: #90EE90; border-color: #90EE90; }
        .pagination .page-item.active .page-link:hover { background-color: #7CFC00; }
        .table-borderless th, .table-borderless td, .table-borderless thead th { border: 1px solid rgba(0,0,0,.05); }
        .table-hover tbody tr:hover { background-color: rgba(90, 255, 90, 0.2); }
        .card-body { background-color: #fff; }
    </style>
    
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


    <h2 class="mb-3 border-top pt-4">Последние действия (История)</h2>
    
    <?php if (!empty($logs)): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Время</th>
                                <th>Пользователь</th>
                                <th>Описание действия</th>
                                <th class="text-end">Детали</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?= htmlspecialchars($log['created_at']) ?></td>
                                    <td><strong><?= htmlspecialchars($log['login'] ?? 'Система') ?></strong></td>
                                    
                                    <td><?= htmlspecialchars(mb_strimwidth($log['action_text'], 0, 50, '...')) ?></td>
                                    
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#logModal<?= $log['id'] ?>">
                                            Подробнее
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="logModal<?= $log['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Детали действия #<?= $log['id'] ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Дата и время:</strong> <?= htmlspecialchars($log['created_at']) ?></p>
                                                <p><strong>Пользователь:</strong> <?= htmlspecialchars($log['login'] ?? 'Система') ?></p>
                                                <p><strong>Затронутый объект (таблица):</strong> <?= htmlspecialchars($log['target_table'] ?? '—') ?> (ID: <?= htmlspecialchars($log['target_id'] ?? '—') ?>)</p>
                                                <hr>
                                                <p><strong>Полное описание:</strong></p>
                                                <div class="alert alert-light border">
                                                    <?= htmlspecialchars($log['action_text']) ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if (isset($totalLogPages) && $totalLogPages > 1): ?>
            <nav aria-label="Logs pagination" class="mb-5">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalLogPages; $i++): ?>
                        <li class="page-item <?= (isset($log_page) && $i == $log_page) ? 'active' : '' ?>">
                            <a class="page-link" href="?log_page=<?= $i ?><?= !empty($search) ? '&search='.urlencode($search) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-secondary mt-3">История действий пока пуста.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include __DIR__ . '/components/footer.view.php'; ?>
