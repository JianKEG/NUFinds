<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../config/accessController.php';

    $page_title = $isAdmin ? "Post Lost & Found Items" : "Post Found Item";
    $base = "../../";
    $active = "post";
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../../includes/head.php'); ?>
<body>
    <?php include('../../includes/admin/header.php'); ?>

            <div class="mb-4">
                <p class="text-primary text-uppercase fw-bold small mb-1">New post</p>
                <h1 class="h3 mb-1"><?php echo $isAdmin ? 'Post a lost or found item' : 'Post a found item'; ?></h1>
                <span class="text-body-secondary small">Enter the details as accurately as possible.</span>
            </div>

            <form id="post-form" class="card shadow-sm mw-100" style="max-width: 880px;" action="../../actions/admin/item/addItem.php" method="POST" enctype="multipart/form-data">
              <div class="card-body p-4">
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152">

                <?php if ($isAdmin): ?>
                <section>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge text-bg-primary">01</span>
                        <div>
                            <h2 class="h6 mb-0">Post type</h2>
                            <small class="text-body-secondary">Is the student looking for this item, or was it turned in?</small>
                        </div>
                    </div>
                    <div class="btn-group w-100" role="group" id="type-toggle" aria-label="Post type">
                        <input type="radio" class="btn-check" name="item_type" id="type-found" value="Found" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="type-found">Found item</label>
                        <input type="radio" class="btn-check" name="item_type" id="type-lost" value="Lost" autocomplete="off">
                        <label class="btn btn-outline-primary" for="type-lost">Lost report</label>
                    </div>
                </section>

                <hr class="my-4" id="student-divider" hidden>

                <section id="student-section" hidden>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge text-bg-primary">02</span>
                        <div>
                            <h2 class="h6 mb-0">Student information</h2>
                            <small class="text-body-secondary">Required for Lost reports.</small>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="student_name">Student name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="student_name" id="student_name" maxlength="255" placeholder="Full name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="student_id">Student ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="student_id" id="student_id" maxlength="12" placeholder="2025-000000">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="255" placeholder="student@students.national-u.edu.ph">
                        </div>
                    </div>
                </section>

                <hr class="my-4">
                <?php else: ?>
                    <input type="hidden" name="item_type" value="Found">
                <?php endif; ?>

                <section>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <?php if ($isAdmin): ?>
                        <span class="badge text-bg-primary" id="item-info-number">02</span>
                        <?php else: ?>
                        <span class="badge text-bg-primary">01</span>
                        <?php endif; ?>
                        <div>
                            <h2 class="h6 mb-0">Item information</h2>
                            <small class="text-body-secondary">Color, brand, and marks help staff verify the owner.</small>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="item_name">Item name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="item_name" name="item_name" maxlength="255" required placeholder="e.g. Black folding umbrella">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="category">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="" disabled selected>Select a category</option>
                                <option>Accessories</option>
                                <option>Bags</option>
                                <option>Electronics</option>
                                <option>IDs &amp; Cards</option>
                                <option>Personal Items</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" id="location-label" for="location">Location found <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location" maxlength="255" required placeholder="e.g. Main Building Lobby">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" id="date-label" for="item_date">Date found <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="item_date" name="item_date" required max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" maxlength="255" placeholder="Add color, brand, distinguishing marks, or other useful details..."></textarea>
                        </div>
                    </div>
                </section>

                <hr class="my-4">

                <section>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <?php if ($isAdmin): ?>
                        <span class="badge text-bg-primary" id="photo-info-number">03</span>
                        <?php else: ?>
                        <span class="badge text-bg-primary">02</span>
                        <?php endif; ?>
                        <div>
                            <h2 class="h6 mb-0">Item photo</h2>
                            <small class="text-body-secondary"><?php echo $isAdmin ? 'A clear photo of the item.' : 'Photo access is limited by your role.'; ?></small>
                        </div>
                    </div>

                    <?php if ($isAdmin): ?>
                        <input class="form-control" id="imageInput" accept="image/jpeg,image/png,image/webp" type="file" name="item_image">
                        <div class="form-text" id="upload-title">PNG, JPG or WEBP, up to 2 MB</div>
                        <img class="img-thumbnail mt-3" id="imagePreview" alt="Photo preview" style="max-height: 220px;" hidden>
                        <p class="text-danger small mt-2 mb-0" id="photo-error" hidden></p>
                    <?php else: ?>
                        <div class="alert alert-secondary mb-0">
                            <strong class="d-block">Photos can only be added by Lost &amp; Found staff.</strong>
                            <span>Your post will appear with a &ldquo;No photo yet&rdquo; placeholder until staff add one.</span>
                        </div>
                    <?php endif; ?>
                </section>

                <div class="d-flex flex-wrap justify-content-end gap-2 border-top mt-4 pt-3">
                    <a class="btn btn-outline-secondary" href="dashboard.php">Cancel</a>
                    <button type="reset" class="btn btn-outline-secondary">Clear form</button>
                    <button type="submit" name="createForm" class="btn btn-primary">Post item</button>
                </div>
              </div>
            </form>

    <?php include('../../includes/admin/footer.php'); ?>
    <script src="../../assets/js/postItem.js"></script>
</body>
</html>
