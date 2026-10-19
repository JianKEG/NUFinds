<div class="d-lg-flex min-vh-100 bg-body-tertiary">
    <?php include($base . 'includes/admin/sidebar.php'); ?>

    <div class="flex-grow-1" style="min-width: 0;">
        <header class="navbar bg-white border-bottom sticky-top px-3">
            <button type="button" class="btn btn-outline-primary d-lg-none me-2" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar" aria-label="Open menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="lh-sm">
                <small class="d-none d-sm-block text-uppercase text-body-secondary"><?php echo $isAdmin ? 'Lost &amp; Found Administration' : 'Campus Support Portal'; ?></small>
                <strong><?php echo $page_title; ?></strong>
            </div>
            <div class="ms-auto text-end lh-sm d-none d-sm-block">
                <strong class="small d-block"><?php echo htmlspecialchars($_SESSION['name']); ?></strong>
                <small class="text-body-secondary"><?php echo $isAdmin ? 'L&amp;F Staff' : 'Guard / Utility'; ?></small>
            </div>
        </header>

        <div class="toast-container position-fixed top-0 end-0 p-3">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4500">
                    <div class="d-flex">
                        <div class="toast-body"><strong>Success</strong><br><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Dismiss"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4500">
                    <div class="d-flex">
                        <div class="toast-body"><strong>Something went wrong</strong><br><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Dismiss"></button>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <main class="container-xxl p-3 p-md-4">
