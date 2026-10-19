<nav class="navbar bg-primary px-3 px-md-5" data-bs-theme="dark">
    <a class="navbar-brand fw-bold" href="<?php echo $base; ?>index.php">NUFinds</a>

    <?php if (isset($_SESSION['username'])): ?>
        <a class="btn btn-outline-light" href="<?php echo $base; ?>pages/admin/dashboard.php">Admin Panel</a>
    <?php else: ?>
        <a class="btn btn-outline-light" href="<?php echo $base; ?>admin.php"><i class="bi bi-lock"></i> Staff Login</a>
    <?php endif; ?>
</nav>
