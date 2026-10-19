<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Go straight to the Admin Panel if already logged in
    if (isset($_SESSION['username'])) {
        header('Location: pages/admin/dashboard.php');
        exit();
    }

    $page_title = "Staff Login";
    $base = "";
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<body class="bg-primary">
    <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center p-3 position-relative">
        <a class="position-absolute top-0 start-0 m-3 link-light text-decoration-none" href="index.php"><i class="bi bi-arrow-left"></i> Back to Student View</a>

        <div class="text-center text-white mb-4">
            <p class="h3 fw-bold mb-1">NUFinds</p>
            <p class="small text-white-50 mb-0">National University Lost &amp; Found</p>
        </div>

        <main class="card shadow-lg w-100" style="max-width: 420px;">
            <div class="card-body p-4">
                <h1 class="h4 text-center">Staff Portal</h1>
                <p class="text-center text-body-secondary small mb-4">Sign in to manage the Lost &amp; Found board.</p>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Unable to sign in</strong><br>
                        <small><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></small>
                    </div>
                <?php endif; ?>

                <form id="formLogin" action="actions/login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" name="loginBtn" class="btn btn-primary w-100">Login to portal</button>
                </form>
            </div>
        </main>

        <p class="small text-white-50 mt-4 mb-0"><i class="bi bi-shield-lock"></i> Secure access for authorized personnel only</p>
    </div>
</body>
</html>
