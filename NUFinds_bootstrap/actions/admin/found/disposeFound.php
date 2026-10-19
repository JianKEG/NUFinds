<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';

    // Only Lost and Found staff (Admin) can dispose items
    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can dispose items.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    $found_id = (int) $_POST['found_id'];

    $updateQuery = "UPDATE found_items SET status = 'Disposed' WHERE found_id = ? AND status = 'Unclaimed'";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param('i', $found_id);
    $stmt->execute();

    $_SESSION['message'] = "Item marked as disposed.";
    header('Location: ../../../pages/admin/foundItems.php');
    exit();
?>
