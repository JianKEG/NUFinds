<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';

    $back = '../../../pages/admin/lostReports.php';

    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can reopen lost reports.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    $report_id = (int) ($_POST['report_id'] ?? 0);
    $updateQuery = "UPDATE lost_items SET status = 'Open' WHERE report_id = ? AND status = 'Resolved'";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param('i', $report_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = 'Lost report reopened.';
    } else {
        $_SESSION['error'] = 'That report is not currently resolved.';
    }

    header("Location: $back");
    exit();
