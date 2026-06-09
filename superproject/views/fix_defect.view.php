<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Починка дефекта - списание материалов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .defect-photo { max-height: 120px; border-radius: 5px; }
    </style>
</head>
<body>
<?php include __DIR__ . '/components/header.view.php'; ?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="bi bi-wrench"></i> Починка дефекта #<?= $defect['id'] ?></h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Дефект:</strong> <?= htmlspecialchars($defect['title']) ?><br>
                <strong>Описание:</strong> <?= nl2br(htmlspecialchars($defect['description'])) ?>
                <?php if (!empty($defect['photo_path'])): ?>
                    <div class="mt-2">
                        <img src="<?= htmlspecialchars($defect['photo_path']) ?>" alt="Фото дефекта" class="defect-photo" onclick="window.open(this.src)">
                    </div>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
            <?php endif; ?>

            <form method="POST" id="fixForm">
                <input type="hidden" name="fix_submit" value="1">
                <input type="hidden" name="fix_id" value="<?= $defect['id'] ?>">

                <h5 class="mb-3">Списание материалов</h5>
                <div id="materialsContainer">
                    <div class="material-row row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Материал</label>
                            <select name="material_id[]" class="form-select" required>
                                <option value="">Выберите материал</option>
                                <?php foreach ($materials as $mat): ?>
                                    <option value="<?= $mat['id'] ?>">
                                        <?= htmlspecialchars($mat['name']) ?> (остаток: <?= $mat['quantity'] ?> <?= $mat['unit'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Количество</label>
                            <input type="number" name="quantity[]" class="form-control" step="0.01" min="0" placeholder="0.00" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-row" style="display:none;"><i class="bi bi-trash"></i> Удалить</button>
                        </div>
                    </div>
                </div>

                <div class="mt-3 mb-4">
                    <button type="button" id="addMaterialBtn" class="btn btn-secondary"><i class="bi bi-plus-circle"></i> Добавить материал</button>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="defects.controller.php" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-check2-circle"></i> Завершить починку</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('materialsContainer');
    const addBtn = document.getElementById('addMaterialBtn');

    // Получаем список материалов из PHP (как JSON)
    const materialsData = <?= json_encode($materials) ?>;

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function generateOptions() {
        let options = '<option value="">Выберите материал</option>';
        materialsData.forEach(mat => {
            options += `<option value="${mat.id}">${escapeHtml(mat.name)} (остаток: ${mat.quantity} ${mat.unit})</option>`;
        });
        return options;
    }

    function createMaterialRow() {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'material-row row g-3 mb-3';
        rowDiv.innerHTML = `
            <div class="col-md-5">
                <label class="form-label">Материал</label>
                <select name="material_id[]" class="form-select" required>${generateOptions()}</select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Количество</label>
                <input type="number" name="quantity[]" class="form-control" step="0.01" min="0" placeholder="0.00" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-row"><i class="bi bi-trash"></i> Удалить</button>
            </div>
        `;
        rowDiv.querySelector('.remove-row').addEventListener('click', function() {
            rowDiv.remove();
            const rows = container.querySelectorAll('.material-row');
            if (rows.length === 1) {
                rows[0].querySelector('.remove-row').style.display = 'none';
            }
        });
        return rowDiv;
    }

    addBtn.addEventListener('click', function() {
        const newRow = createMaterialRow();
        container.appendChild(newRow);
        const rows = container.querySelectorAll('.material-row');
        rows.forEach(row => {
            row.querySelector('.remove-row').style.display = 'inline-block';
        });
    });

    // Инициализация: скрыть кнопку удаления, если только одна строка
    const initialRows = container.querySelectorAll('.material-row');
    if (initialRows.length === 1) {
        initialRows[0].querySelector('.remove-row').style.display = 'none';
    }
</script>

<?php include __DIR__ . '/components/footer.view.php'; ?>
</body>
</html>