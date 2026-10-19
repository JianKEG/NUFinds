<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../config/accessController.php';

    if (!$isAdmin) {
        $_SESSION['error'] = "That page is for Lost and Found staff only.";
        header('Location: dashboard.php');
        exit();
    }

    $found_id = (int) ($_GET['id'] ?? 0);
    require '../../config/connection.php';
    $stmt = $connection->prepare("SELECT item_name, category, description, location_found FROM found_items WHERE found_id = ? AND status = 'Unclaimed'");
    $stmt->bind_param('i', $found_id);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();

    if (!$item) {
        $_SESSION['error'] = "Only unclaimed items can be edited.";
        header('Location: foundItems.php');
        exit();
    }

    $page_title = "Edit Found Item";
    $base = '../../';
    $active = 'found';
    $categories = ['Accessories', 'Bags', 'Electronics', 'IDs & Cards', 'Personal Items', 'Other'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include('../../includes/head.php'); ?>
<body>
    <?php include('../../includes/admin/header.php'); ?>

            <div class="mb-4">
                <p class="text-primary text-uppercase fw-bold small mb-1">Found item</p>
                <h1 class="h3 mb-1">Edit item details</h1>
                <span class="text-body-secondary small">Update the details while this item is still unclaimed.</span>
            </div>

            <form class="card shadow-sm" style="max-width: 880px;" action="../../actions/admin/found/editFound.php" method="POST">
                <div class="card-body p-4">
                    <input type="hidden" name="found_id" value="<?php echo $found_id; ?>">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="item_name">Item name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="item_name" name="item_name" maxlength="255" required value="<?php echo htmlspecialchars($item['item_name']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="category">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <?php foreach ($categories as $category) { ?>
                                    <option <?php echo $item['category'] === $category ? 'selected' : ''; ?>><?php echo htmlspecialchars($category); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="location">Location found <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location" maxlength="255" required value="<?php echo htmlspecialchars($item['location_found']); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" maxlength="255"><?php echo htmlspecialchars($item['description'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 border-top mt-4 pt-3">
                        <a class="btn btn-outline-secondary" href="foundItems.php">Cancel</a>
                        <button type="submit" name="editForm" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>

    <?php include('../../includes/admin/footer.php'); ?>
</body>
</html>
