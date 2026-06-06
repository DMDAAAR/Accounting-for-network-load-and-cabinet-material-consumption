<?php
if (!defined('APP_LOADED')) die('Прямой доступ запрещен');
?>
<footer style="background-color: #f0fff0; border-top: 2px solid #90EE90; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; margin-top: auto;">    <div class="container-fluid px-3 px-md-5">
        <div class="row align-items-center py-3 gy-2">
            <div class="col-md-4 text-center text-md-start">
                <span class="text-muted small">© <?= date('Y') ?> Учёт ЛВС — Кабинеты КИМРТ</span>
            </div>
            <div class="col-md-4 text-center">
                <a href="https://github.com/DMDAAAR/Accounting-for-network-load-and-cabinet-material-consumption.git" target="_blank" class="text-decoration-none" style="color: #2c5e2c;">
                    <i class="bi bi-github me-1"></i> GitHub репозиторий
                </a>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <span class="text-muted small"><i class="bi bi-shield-check me-1"></i> Версия 1.0</span>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
