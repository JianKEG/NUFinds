<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';

    $back = '../../../pages/admin/lostReports.php';

    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can delete lost reports.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    $report_id = (int) ($_POST['report_id'] ?? 0);
    $stmt = $connection->prepare('SELECT img_path FROM lost_items WHERE report_id = ?');
    $stmt->bind_param('i', $report_id);
    $stmt->execute();
    $report = $stmt->get_result()->fetch_assoc();

    if (!$report) {
        $_SESSION['error'] = 'That lost report could not be found.';
        header("Location: $back");
        exit();
    }

    try {
        $stmt = $connection->prepare('DELETE FROM lost_items WHERE report_id = ?');
        $stmt->bind_param('i', $report_id);
        $stmt->execute();

        if (!empty($report['img_path'])) {
            $oldFile = __DIR__ . '/../../../assets/uploads/' . basename($report['img_path']);
            if (is_file($oldFile)) {
                unlink($oldFile);
            }
        }

        $_SESSION['message'] = 'Lost report deleted.';
    } catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = 'Could not delete that report. Please try again.';
    }

    header("Location: $back");
    exit();
