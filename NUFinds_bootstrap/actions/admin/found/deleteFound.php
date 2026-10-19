<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';

    $back = '../../../pages/admin/foundItems.php';

    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can delete found items.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    $found_id = (int) ($_POST['found_id'] ?? 0);
    $stmt = $connection->prepare('SELECT img_path FROM found_items WHERE found_id = ?');
    $stmt->bind_param('i', $found_id);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();

    if (!$item) {
        $_SESSION['error'] = "That found item could not be found.";
        header("Location: $back");
        exit();
    }

    try {
        $connection->begin_transaction();

        $stmt = $connection->prepare('DELETE FROM claim_item WHERE found_id = ?');
        $stmt->bind_param('i', $found_id);
        $stmt->execute();

        $stmt = $connection->prepare('DELETE FROM found_items WHERE found_id = ?');
        $stmt->bind_param('i', $found_id);
        $stmt->execute();
        $connection->commit();

        if (!empty($item['img_path'])) {
            $oldFile = __DIR__ . '/../../../assets/uploads/' . basename($item['img_path']);
            if (is_file($oldFile)) {
                unlink($oldFile);
            }
        }

        $_SESSION['message'] = 'Found item deleted.';
    } catch (mysqli_sql_exception $e) {
        $connection->rollback();
        $_SESSION['error'] = 'Could not delete that item. Please try again.';
    }

    header("Location: $back");
    exit();
