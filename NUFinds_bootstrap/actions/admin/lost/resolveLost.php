<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';

    // Only Lost and Found staff (Admin) can resolve lost reports
    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can resolve lost reports.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    $report_id = (int) $_POST['report_id'];

    $updateQuery = "UPDATE lost_items SET status = 'Resolved' WHERE report_id = ? AND status = 'Open'";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param('i', $report_id);
    $stmt->execute();

    $_SESSION['message'] = "Lost report marked as resolved.";
    header('Location: ../../../pages/admin/lostReports.php');
    exit();
?>
