<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';

    $back = '../../../pages/admin/foundItems.php';

    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can unclaim found items.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    $found_id = (int) ($_POST['found_id'] ?? 0);

    try {
        $connection->begin_transaction();

        $stmt = $connection->prepare("UPDATE found_items SET status = 'Unclaimed' WHERE found_id = ? AND status = 'Claimed'");
        $stmt->bind_param('i', $found_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            $connection->rollback();
            $_SESSION['error'] = "That item is no longer claimed.";
            header("Location: $back");
            exit();
        }

        $stmt = $connection->prepare('DELETE FROM claim_item WHERE found_id = ?');
        $stmt->bind_param('i', $found_id);
        $stmt->execute();

        $connection->commit();
        $_SESSION['message'] = 'Item returned to the unclaimed list.';
    } catch (mysqli_sql_exception $e) {
        $connection->rollback();
        $_SESSION['error'] = 'Could not unclaim that item. Please try again.';
    }

    header("Location: $back");
    exit();
