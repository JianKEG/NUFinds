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

    $page_title = "Found Items";
    $base = "../../";
    $active = "found";

    require '../../actions/admin/found/foundQuery.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../../includes/head.php'); ?>
<body>
    <?php include('../../includes/admin/header.php'); ?>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                <div>
                    <h1 class="h3 mb-1">Found items</h1>
                    <span class="text-body-secondary small">Add photos, verify owners, and mark items as claimed.</span>
                </div>
                <a class="btn btn-warning" href="postItem.php">Post item</a>
            </div>

            <section class="card shadow-sm">
                <div class="card-body border-bottom" data-filter-scope data-target="#items-body" data-count="#items-count">
                    <div class="row g-2">
                        <div class="col-12 col-md">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control" data-filter="search" placeholder="Search items or locations...">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <select class="form-select" data-filter="status" aria-label="Status">
                                <option value="">All statuses</option>
                                <option>Unclaimed</option>
                                <option>Claimed</option>
                                <option>Disposed</option>
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
                                <th>Category</th>
                                <th>Location</th>
                                <th>Date found</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="items-body">
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <tr data-search="<?php echo htmlspecialchars(strtolower($row['item_name'] . ' ' . $row['description'] . ' ' . $row['location_found'] . ' ' . $row['student_name'])); ?>"
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
                                                <?php if (!empty($row['description'])) { ?>
                                                    <small class="d-block text-body-secondary"><?php echo htmlspecialchars($row['description']); ?></small>
                                                <?php } ?>
                                                <?php if ($row['status'] == 'Claimed') { ?>
                                                    <small class="d-block text-primary fw-semibold">
                                                        Claimed by <?php echo htmlspecialchars($row['student_name']); ?>
                                                        (<?php echo htmlspecialchars($row['student_id']); ?>)
                                                    </small>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                                    <td><?php echo htmlspecialchars($row['location_found']); ?></td>
                                    <td class="text-nowrap"><?php echo date('M d, Y', strtotime($row['date_found'])); ?></td>
                                    <td>
                                        <span class="badge rounded-pill text-bg-<?php echo $row['status'] == 'Unclaimed' ? 'success' : 'secondary'; ?>"><?php echo $row['status']; ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php if ($row['status'] == 'Unclaimed') { ?>
                                                <form class="photo-form" action="../../actions/admin/item/uploadPhoto.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="kind" value="found">
                                                    <input type="hidden" name="id" value="<?php echo $row['found_id']; ?>">
                                                    <input type="file" name="item_image" accept="image/jpeg,image/png,image/webp" hidden>
                                                    <button type="button" class="btn btn-sm btn-outline-primary js-replace-photo"><?php echo empty($row['img_path']) ? 'Add photo' : 'Replace photo'; ?></button>
                                                </form>
                                                <a class="btn btn-sm btn-outline-secondary" href="editFound.php?id=<?php echo $row['found_id']; ?>">Edit</a>
                                                <button type="button" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal" data-bs-target="#claim-modal"
                                                        data-id="<?php echo $row['found_id']; ?>"
                                                        data-name="<?php echo htmlspecialchars($row['item_name']); ?>">Mark claimed</button>

                                                <form action="../../actions/admin/found/disposeFound.php" method="POST"
                                                      onsubmit="return confirm('Mark this item as disposed? This cannot be undone.');">
                                                    <input type="hidden" name="found_id" value="<?php echo $row['found_id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-warning">Dispose</button>
                                                </form>
                                            <?php } elseif ($row['status'] == 'Claimed') { ?>
                                                <form action="../../actions/admin/found/unclaimFound.php" method="POST"
                                                      onsubmit="return confirm('Unclaim this item? The claimant details will be removed and the item will return to the unclaimed list.');">
                                                    <input type="hidden" name="found_id" value="<?php echo $row['found_id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-info">Unclaim</button>
                                                </form>
                                            <?php } ?>
                                            <form action="../../actions/admin/found/deleteFound.php" method="POST"
                                                  onsubmit="return confirm('Delete this found item permanently?');">
                                                <input type="hidden" name="found_id" value="<?php echo $row['found_id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr class="no-results" hidden><td colspan="6" class="text-center text-body-secondary py-4">No items match your filters.</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white small text-body-secondary">
                    <span id="items-count">Showing <?php echo $totalRows; ?> of <?php echo $totalRows; ?> items</span>
                </div>
            </section>

            <!-- Mark as claimed: record who the item was returned to -->
            <div class="modal fade" id="claim-modal" tabindex="-1" aria-labelledby="claim-title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form class="modal-content" action="../../actions/admin/found/claimFound.php" method="POST">
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="claim-title">Mark item as claimed?</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="small text-body-secondary">Verify the owner of <strong id="claim-name"></strong>, then enter their details. This updates the public board.</p>
                            <input type="hidden" name="found_id" id="claim-id" value="">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="claim-student-name">Student name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="claim-student-name" name="student_name" required maxlength="255" placeholder="Full name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="claim-student-id">Student ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="claim-student-id" name="student_id" required maxlength="12" placeholder="2025-000000">
                            </div>
                            <div>
                                <label class="form-label fw-semibold" for="claim-email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="claim-email" name="email" required maxlength="255" placeholder="student@students.national-u.edu.ph">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="claimForm" class="btn btn-primary">Confirm claim</button>
                        </div>
                    </form>
                </div>
            </div>

    <?php include('../../includes/admin/footer.php'); ?>
    <script src="../../assets/js/tableFilter.js"></script>
    <script src="../../assets/js/photoReplace.js"></script>
    <script src="../../assets/js/foundItems.js"></script>
</body>
</html>
