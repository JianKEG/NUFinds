<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Student View: public, view only, no login
    $page_title = "Lost & Found Board";
    $base = "";

    require 'actions/student/boardQuery.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<body class="bg-body-tertiary">
    <div class="d-flex flex-column min-vh-100">
        <?php include('includes/student/header.php'); ?>

        <main class="flex-grow-1">
            <section class="bg-primary text-white py-5 px-3 px-md-5">
                <div class="container d-flex align-items-center justify-content-between">
                    <div>
                        <span class="d-block text-warning text-uppercase fw-bold small mb-2">National University &bull; Laguna</span>
                        <h1 class="display-5 fw-bold">Browse found items and<br><span class="text-warning">recent lost-item reports</span><br>from around campus.</h1>
                    </div>
                    <i class="bi bi-search display-1 text-warning d-none d-md-block"></i>
                </div>
            </section>

            <section class="container py-5">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <p class="text-primary text-uppercase fw-bold small mb-1">Campus lost &amp; found</p>
                        <h2 class="h3 mb-0">Lost &amp; found items</h2>
                    </div>
                    <span class="badge rounded-pill text-bg-light border" id="result-count"></span>
                </div>

                <div class="card card-body shadow-sm mb-4">
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="search" class="form-control" id="search" placeholder="Search" autocomplete="off">
                                <label for="search">Search items, e.g. umbrella</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="filter-category">
                                    <option value="">All categories</option>
                                    <option>Accessories</option>
                                    <option>Bags</option>
                                    <option>Electronics</option>
                                    <option>IDs &amp; Cards</option>
                                    <option>Personal Items</option>
                                    <option>Other</option>
                                </select>
                                <label for="filter-category">Category</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-floating">
                                <select class="form-select" id="filter-status">
                                    <option value="">All statuses</option>
                                    <option>Lost</option>
                                    <option>Found</option>
                                    <option>Claimed</option>
                                </select>
                                <label for="filter-status">Status</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4" id="item-grid">
                    <?php while ($row = mysqli_fetch_array($boardResult)) { ?>
                        <?php $badge = ['Found' => 'success', 'Lost' => 'warning', 'Claimed' => 'secondary'][$row['board_status']]; ?>
                        <div class="col item-card"
                             data-search="<?php echo htmlspecialchars(strtolower($row['item_name'] . ' ' . $row['location'] . ' ' . $row['category'])); ?>"
                             data-category="<?php echo htmlspecialchars($row['category']); ?>"
                             data-status="<?php echo $row['board_status']; ?>">
                            <article class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <div class="ratio ratio-4x3 bg-body-secondary">
                                        <?php if (!empty($row['img_path'])) { ?>
                                            <img class="object-fit-contain" src="assets/uploads/<?php echo htmlspecialchars($row['img_path']); ?>" alt="<?php echo htmlspecialchars($row['item_name']); ?>">
                                        <?php } else { ?>
                                            <div class="d-flex flex-column align-items-center justify-content-center text-body-secondary">
                                                <i class="bi bi-image fs-2"></i>
                                                <small>No photo yet</small>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <span class="badge rounded-pill text-bg-<?php echo $badge; ?> position-absolute top-0 end-0 m-2"><?php echo strtoupper($row['board_status']); ?></span>
                                </div>

                                <div class="card-body">
                                    <p class="text-uppercase small fw-bold text-body-secondary mb-1"><i class="bi bi-tag"></i> <?php echo htmlspecialchars($row['category']); ?></p>
                                    <h3 class="h6 card-title"><?php echo htmlspecialchars($row['item_name']); ?></h3>
                                    <?php if (!empty($row['description'])) { ?>
                                        <p class="card-text small text-body-secondary"><?php echo htmlspecialchars($row['description']); ?></p>
                                    <?php } ?>
                                    <p class="small text-body-secondary mb-1">
                                        <i class="bi bi-geo-alt text-primary"></i>
                                        <?php echo $row['kind'] == 'lost' ? 'Last seen at' : 'Found at'; ?> <?php echo htmlspecialchars($row['location']); ?>
                                    </p>
                                    <p class="small text-body-secondary mb-0">
                                        <i class="bi bi-calendar-event text-primary"></i>
                                        <?php echo $row['kind'] == 'lost' ? 'Lost' : 'Found'; ?> <?php echo date('M d, Y', strtotime($row['item_date'])); ?>
                                    </p>
                                </div>
                            </article>
                        </div>
                    <?php } ?>
                </div>

                <div class="text-center bg-white border rounded p-5" id="empty-state" hidden>
                    <h3 class="h5">No matching items</h3>
                    <p class="text-body-secondary small">Try adjusting your search or filters to see more results.</p>
                    <button type="button" class="btn btn-link" id="clear-filters">Clear all filters</button>
                </div>
            </section>
        </main>

        <?php include('includes/footer.php'); ?>
    </div>

    <script src="assets/js/board.js"></script>
</body>
</html>
