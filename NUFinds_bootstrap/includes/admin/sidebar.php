<aside class="offcanvas-lg offcanvas-start sticky-lg-top flex-grow-0 flex-shrink-0 align-self-lg-start" tabindex="-1" id="sidebar" aria-label="Main menu" style="--bs-offcanvas-width: 250px;">
    <div class="offcanvas-body p-0">
        <div class="bg-primary text-white d-flex flex-column w-100 min-vh-100 p-3" data-bs-theme="dark">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom border-light border-opacity-25">
                <span class="fs-4 fw-bold">NUFinds</span>
                <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Close menu"></button>
            </div>

            <p class="text-uppercase small fw-semibold text-white-50 px-2 mb-2">Workspace</p>

            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item">
                    <a href="<?php echo $base; ?>pages/admin/dashboard.php" class="nav-link d-flex align-items-center gap-2 <?php echo $active == 'dashboard' ? 'active' : ''; ?>">
                        <i class="bi bi-grid"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $base; ?>pages/admin/postItem.php" class="nav-link d-flex align-items-center gap-2 <?php echo $active == 'post' ? 'active' : ''; ?>">
                        <i class="bi bi-plus-lg"></i> <?php echo $isAdmin ? 'Post Lost &amp; Found Items' : 'Post Found Item'; ?>
                    </a>
                </li>
                <?php if ($isAdmin): ?>
                <li class="nav-item">
                    <a href="<?php echo $base; ?>pages/admin/foundItems.php" class="nav-link d-flex align-items-center gap-2 <?php echo $active == 'found' ? 'active' : ''; ?>">
                        <i class="bi bi-box-seam"></i> Found Items
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $base; ?>pages/admin/lostReports.php" class="nav-link d-flex align-items-center gap-2 <?php echo $active == 'lost' ? 'active' : ''; ?>">
                        <i class="bi bi-clipboard"></i> Lost Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $base; ?>pages/admin/claims.php" class="nav-link d-flex align-items-center gap-2 <?php echo $active == 'claims' ? 'active' : ''; ?>">
                        <i class="bi bi-check-lg"></i> Claims
                    </a>
                </li>
                <?php endif; ?>
            </ul>

            <div class="mt-auto pt-4">
                <div class="d-flex align-items-center border border-light border-opacity-25 rounded p-2 mb-2 bg-white bg-opacity-10">
                    <div class="lh-sm">
                        <div class="small fw-semibold"><?php echo $isAdmin ? 'L&amp;F Staff' : 'Utility Staff'; ?></div>
                        <div class="small text-white-50"><?php echo $isAdmin ? 'Full access' : 'Limited access'; ?></div>
                    </div>
                    <span class="badge bg-warning text-black ms-auto"><?php echo $isAdmin ? 'ADMIN' : 'STAFF'; ?></span>
                </div>

                <form action="<?php echo $base; ?>actions/logout.php" method="POST">
                    <button type="submit" class="btn btn-outline-light btn-sm w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
                <a class="link-light link-opacity-75 small d-block mt-2 text-center" href="<?php echo $base; ?>index.php">View student board</a>
            </div>
        </div>
    </div>
</aside>
