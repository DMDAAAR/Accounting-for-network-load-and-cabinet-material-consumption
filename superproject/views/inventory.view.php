<?php 
include __DIR__ . '/components/header.view.php'; 
?>
<div class="container-fluid mt-4">
    <h2>Оборудование и материалы</h2>
    <hr>

    <div class="card mb-4">
        <div class="card-header <?php echo $edit_point ? 'bg-warning text-dark' : 'bg-primary text-white'; ?>">
            <h5 class="mb-0">
                <?php echo $edit_point ? 'Редактировать точку сети (ID: ' . $edit_point['id'] . ')' : 'Добавить новую точку сети'; ?>
            </h5>
        </div>
        <div class="card-body">
            <form action="inventory.controller.php" method="POST" class="row g-3">
                <input type="hidden" name="action" value="<?php echo $edit_point ? 'edit' : 'add'; ?>">
                
                <?php if ($edit_point): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_point['id']; ?>">
                <?php endif; ?>
                
                <div class="col-md-3">
                    <label for="label" class="form-label">Метка (Label)</label>
                    <input type="text" class="form-control" id="label" name="label" required 
                        placeholder="Например, Розетка-09"
                        value="<?php echo $edit_point ? htmlspecialchars($edit_point['label']) : ''; ?>">
                </div>
                
                <div class="col-md-3">
                    <label for="type" class="form-label">Тип устройства</label>
                    <select class="form-select" id="type" name="type" required>
                        <?php $current_type = $edit_point ? $edit_point['type'] : 'socket'; ?>
                        <option value="socket" <?php echo $current_type === 'socket' ? 'selected' : ''; ?>>Розетка (socket)</option>
                        <option value="switch" <?php echo $current_type === 'switch' ? 'selected' : ''; ?>>Коммутатор (switch)</option>
                        <option value="cable_run" <?php echo $current_type === 'cable_run' ? 'selected' : ''; ?>>Трасса кабеля (cable_run)</option>
                        <option value="patch_cord" <?php echo $current_type === 'patch_cord' ? 'selected' : ''; ?>>Патч-корд (patch_cord)</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="status" class="form-label">Статус</label>
                    <select class="form-select" id="status" name="status" required>
                        <?php $current_status = $edit_point ? $edit_point['status'] : 'active'; ?>
                        <option value="active" <?php echo $current_status === 'active' ? 'selected' : ''; ?>>Активно (active)</option>
                        <option value="defect" <?php echo $current_status === 'defect' ? 'selected' : ''; ?>>Дефект (defect)</option>
                        <option value="decommissioned" <?php echo $current_status === 'decommissioned' ? 'selected' : ''; ?>>Списано (decommissioned)</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="location_id" class="form-label">Кабинет / Локация</label>
                    <select class="form-select" id="location_id" name="location_id">
                        <option value="">-- Не выбрано --</option>
                        <?php if (isset($rooms) && is_array($rooms)): ?>
                            <?php foreach ($rooms as $room): ?>
                                <?php $selected = ($edit_point && $edit_point['location_id'] == $room['id']) ? 'selected' : ''; ?>
                                <option value="<?php echo $room['id']; ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($room['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="col-12 text-end">
                    <?php if ($edit_point): ?>
                        <a href="inventory.controller.php" class="btn btn-secondary me-2">Отмена</a>
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-success">Добавить оборудование</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <h4>Точки сети в системе</h4>
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Метка</th>
                <th>Тип</th>
                <th>Статус</th>
                <th>Локация</th>
                <th class="text-center">Действия</th>
            </tr>
        </thead>
        <tbody>
        <?php if (isset($points) && is_array($points) && count($points) > 0): ?>
            <?php foreach ($points as $point): ?>
                <tr <?php echo ($edit_point && $edit_point['id'] == $point['id']) ? 'class="table-warning"' : ''; ?>>
                    <td><?php echo $point['id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($point['label']); ?></strong></td>
                    <td><?php echo htmlspecialchars($point['type']); ?></td>
                    <td>
                        <?php 
                        $badgeColor = 'bg-secondary';
                        if ($point['status'] === 'active') $badgeColor = 'bg-success';
                        if ($point['status'] === 'defect') $badgeColor = 'bg-danger';
                        ?>
                        <span class="badge <?php echo $badgeColor; ?>">
                            <?php echo htmlspecialchars($point['status']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($point['location_name'] ?? '—'); ?></td>
                    <td class="text-center">
                        <a href="inventory.controller.php?edit_id=<?php echo $point['id']; ?>" 
                        class="btn btn-sm btn-warning">
                            Изменить
                        </a>
                        
                        <a href="inventory.controller.php?action=delete&id=<?php echo $point['id']; ?>" 
                        class="btn btn-sm btn-danger" 
                        onclick="return confirm('Вы уверены, что хотите удалить точку «<?php echo htmlspecialchars($point['label']); ?>»?');">
                            Удалить
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-muted">Данные о точках сети отсутствуют или не переданы из контроллера</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
include __DIR__ . '/components/footer.view.php'; 
?>