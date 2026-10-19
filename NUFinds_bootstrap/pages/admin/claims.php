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

    $page_title = "Claims";
    $base = "../../";
    $active = "claims";

    require '../../actions/admin/claim/claimQuery.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../../includes/head.php'); ?>
<body>
    <?php include('../../includes/admin/header.php'); ?>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                <div>
                    <p class="text-primary text-uppercase fw-bold small mb-1">Staff only</p>
                    <h1 class="h3 mb-1">Claim log</h1>
                    <span class="text-body-secondary small">Every item returned to its owner.</span>
                </div>
            </div>

            <section class="card shadow-sm">
                <div class="card-body border-bottom" data-filter-scope data-target="#claims-body" data-count="#claims-count">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control" data-filter="search" placeholder="Search by student name, ID, or item...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Claim date</th>
                                <th>Item</th>
                                <th>Claimed by</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="claims-body">
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <tr data-search="<?php echo htmlspecialchars(strtolower($row['item_name'] . ' ' . $row['student_name'] . ' ' . $row['student_id'])); ?>">
                                    <td><?php echo date('M d, Y', strtotime($row['claim_date'])); ?></td>
                                    <td>
                                        <strong class="d-block"><?php echo htmlspecialchars($row['item_name']); ?></strong>
                                        <small class="text-primary fw-semibold"><?php echo htmlspecialchars($row['category']); ?></small>
                                    </td>
                                    <td>
                                        <strong class="d-block"><?php echo htmlspecialchars($row['student_name']); ?></strong>
                                        <small class="text-primary fw-semibold"><?php echo htmlspecialchars($row['student_id']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                </tr>
                            <?php } ?>
                            <tr class="no-results" <?php echo $totalRows > 0 ? 'hidden' : ''; ?>><td colspan="4" class="text-center text-body-secondary py-4">No claims yet.</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white small text-body-secondary">
                    <span id="claims-count">Showing <?php echo $totalRows; ?> of <?php echo $totalRows; ?> claims</span>
                </div>
            </section>

    <?php include('../../includes/admin/footer.php'); ?>
    <script src="../../assets/js/tableFilter.js"></script>
</body>
</html>
