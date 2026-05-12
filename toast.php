    <!-- TOAST -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <?php if ($succ): ?>
        <div id="toastSUCC" class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body"><?= htmlspecialchars($succ) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>        
        <?php if ($error): ?>
        <div id="toastERR" class="toast align-items-center text-bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body"><?= htmlspecialchars($error) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>