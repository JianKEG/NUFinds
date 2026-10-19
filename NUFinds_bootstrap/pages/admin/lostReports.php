<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../config/accessController.php';

    // Lost and Found staff (Admin) only
    if (!$isAdmin) {
        $_SESSION['error'] = "That page is for Lost and Found staff only.";
        header('Location: dashboard.php');
        exit();
    }

    $page_title = "Lost Reports";
    $base = "../../";
    $active = "lost";

    require '../../actions/admin/lost/lostQuery.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../../includes/head.php'); ?>
<body>
    <?php include('../../includes/admin/header.php'); ?>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                <div>
                    <h1 class="h3 mb-1">Lost reports</h1>
                    <span class="text-body-secondary small">Reports taken at the Lost and Found room. Student details are private.</span>
                </div>
                <a class="btn btn-warning" href="postItem.php">Log a report</a>
            </div>

            <section class="card shadow-sm">
                <div class="card-body border-bottom" data-filter-scope data-target="#reports-body" data-count="#reports-count">
                    <div class="row g-2">
                        <div class="col-12 col-md">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control" data-filter="search" placeholder="Search by student name, ID, or item...">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select" data-filter="status" aria-label="Status">
                                <option value="">All statuses</option>
                                <option>Open</option>
                                <option>Resolved</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select" data-filter="category" aria-label="Category">
                                <option value="">All categories</option>
                                <option>Accessories</option>
                                <option>Bags</option>
                                <option>Electronics</option>
                                <option>IDs &amp; Cards</option>
                                <option>Personal Items</option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Student</th>
                                <th>Last seen</th>
                                <th>Reported</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reports-body">
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <tr data-search="<?php echo htmlspecialchars(strtolower($row['item_name'] . ' ' . $row['student_name'] . ' ' . $row['student_id'])); ?>"
                                    data-status="<?php echo $row['status']; ?>"
                                    data-category="<?php echo htmlspecialchars($row['category']); ?>">
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (!empty($row['img_path'])) { ?>
                                                <img class="rounded object-fit-cover" width="40" height="40" src="../../assets/uploads/<?php echo htmlspecialchars($row['img_path']); ?>" alt="">
                                            <?php } else { ?>
                                                <i class="bi bi-image fs-1 text-body-secondary"></i>
                                            <?php } ?>
                                            <div>
                                                <strong class="d-block"><?php echo htmlspecialchars($row['item_name']); ?></strong>
                                                <small class="text-primary fw-semibold"><?php echo htmlspecialchars($row['category']); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="d-block"><?php echo htmlspecialchars($row['student_name']); ?></strong>
                                        <small class="d-block text-body-secondary"><?php echo htmlspecialchars($row['student_id']); ?></small>
                                        <small class="d-block text-body-secondary"><?php echo htmlspecialchars($row['email']); ?></small>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($row['location_lost'] ?? 'Not specified'); ?>
                                        <?php if (!empty($row['date_lost'])) { echo '<br>' . date('M d, Y', strtotime($row['date_lost'])); } ?>
                                    </td>
                                    <td class="text-nowrap"><?php echo date('M d, Y', strtotime($row['date_reported'])); ?></td>
                                    <td>
                                        <span class="badge rounded-pill text-bg-<?php echo $row['status'] == 'Open' ? 'warning' : 'secondary'; ?>"><?php echo $row['status']; ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <form class="photo-form" action="../../actions/admin/item/uploadPhoto.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="kind" value="lost">
                                                    <input type="hidden" name="id" value="<?php echo $row['report_id']; ?>">
                                                    <input type="file" name="item_image" accept="image/jpeg,image/png,image/webp" hidden>
                                                    <button type="button" class="btn btn-sm btn-outline-primary js-replace-photo"><?php echo empty($row['img_path']) ? 'Add photo' : 'Replace photo'; ?></button>
                                                </form>

                                            <?php if ($row['status'] == 'Open') { ?>
                                                <form action="../../actions/admin/lost/resolveLost.php" method="POST"
                                                      onsubmit="return confirm('Mark this lost report as resolved?');">
                                                    <input type="hidden" name="report_id" value="<?php echo $row['report_id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-success">Mark resolved</button>
                                                </form>
                                            <?php } else { ?>
                                                <form action="../../actions/admin/lost/reopenLost.php" method="POST"
                                                      onsubmit="return confirm('Reopen this lost report?');">
                                                    <input type="hidden" name="report_id" value="<?php echo $row['report_id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-info">Reopen</button>
                                                </form>
                                            <?php } ?>
                                            <form action="../../actions/admin/lost/deleteLost.php" method="POST"
                                                  onsubmit="return confirm('Delete this lost report permanently?');">
                                                <input type="hidden" name="report_id" value="<?php echo $row['report_id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr class="no-results" <?php echo $totalRows > 0 ? 'hidden' : ''; ?>><td colspan="6" class="text-center text-body-secondary py-4">No reports found.</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white small text-body-secondary">
                    <span id="reports-count">Showing <?php echo $totalRows; ?> of <?php echo $totalRows; ?> reports</span>
                </div>
            </section>

    <?php include('../../includes/admin/footer.php'); ?>
    <script src="../../assets/js/tableFilter.js"></script>
    <script src="../../assets/js/photoReplace.js"></script>
</body>
</html>
