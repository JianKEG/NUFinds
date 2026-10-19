<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../config/accessController.php';

    $base = "../../";
    $active = "dashboard";

    require '../../actions/admin/dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../../includes/head.php'); ?>
<body>
    <?php include('../../includes/admin/header.php'); ?>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                <div>
                    <p class="text-primary text-uppercase fw-bold small mb-1">Overview</p>
                    <h1 class="h3 mb-1">Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>.</h1>
                    <span class="text-body-secondary small">Here&rsquo;s what&rsquo;s happening with Lost &amp; Found today.</span>
                </div>
                <a class="btn btn-warning" href="postItem.php"><?php echo $isAdmin ? 'Post lost or found item' : 'Post found item'; ?></a>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-<?php echo $isAdmin ? 4 : 3; ?> g-3 mb-4">
                <div class="col">
                    <div class="card h-100 shadow-sm"><div class="card-body">
                        <p class="small fw-semibold text-body-secondary mb-1">Unclaimed Items</p>
                        <p class="h3 mb-0"><?php echo $unclaimedCount; ?></p>
                    </div></div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm"><div class="card-body">
                        <p class="small fw-semibold text-body-secondary mb-1">Claimed Items</p>
                        <p class="h3 mb-0"><?php echo $claimedCount; ?></p>
                    </div></div>
                </div>
                <?php if ($isAdmin): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm"><div class="card-body">
                        <p class="small fw-semibold text-body-secondary mb-1">Open Lost Reports</p>
                        <p class="h3 mb-0"><?php echo $openLostCount; ?></p>
                    </div></div>
                </div>
                <?php endif; ?>
                <div class="col">
                    <div class="card h-100 shadow-sm"><div class="card-body">
                        <p class="small fw-semibold text-body-secondary mb-1">Total Found Items</p>
                        <p class="h3 mb-0"><?php echo $totalFoundCount; ?></p>
                    </div></div>
                </div>
            </div>

            <section class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h6 mb-0">Recent found items</h2>
                        <small class="text-body-secondary">Latest items posted</small>
                    </div>
                    <?php if ($isAdmin): ?>
                        <a class="small fw-bold text-decoration-none" href="foundItems.php">View all &rsaquo;</a>
                    <?php endif; ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Location</th>
                                <th>Date found</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($recentResult) == 0) { ?>
                                <tr><td colspan="4" class="text-center text-body-secondary py-4">No items posted yet.</td></tr>
                            <?php } ?>
                            <?php while ($row = mysqli_fetch_array($recentResult)) { ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (!empty($row['img_path'])) { ?>
                                                <img class="rounded object-fit-cover" width="40" height="40" src="../../assets/uploads/<?php echo htmlspecialchars($row['img_path']); ?>" alt="">
                                            <?php } else { ?>
                                                <i class="bi bi-image fs-1 text-body-secondary"></i>
                                            <?php } ?>
                                            <strong><?php echo htmlspecialchars($row['item_name']); ?></strong>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['location_found']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['date_found'])); ?></td>
                                    <td>
                                        <span class="badge rounded-pill text-bg-<?php echo $row['status'] == 'Unclaimed' ? 'success' : 'secondary'; ?>"><?php echo $row['status']; ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <?php if (!$isAdmin): ?>
                <div class="alert alert-warning d-flex align-items-center gap-3 mt-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill fs-4"></i>
                    <div>
                        <strong class="d-block">Your access is limited to posting found items.</strong>
                        <span>Photos, claims, and lost reports are managed by Lost &amp; Found staff.</span>
                    </div>
                </div>
            <?php endif; ?>

    <?php include('../../includes/admin/footer.php'); ?>
</body>
</html>
