<?php
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: ../../../admin.php');
    exit();
}

// 'Admin' = Lost & Found Staff, 'Staff' = Utility / Guard
$isAdmin = ($_SESSION['role'] === 'Admin');
?>
