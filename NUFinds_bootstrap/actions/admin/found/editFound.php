<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';

    $back = '../../../pages/admin/foundItems.php';

    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can edit found items.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    if (isset($_POST['editForm'])) {
        $found_id = (int) $_POST['found_id'];
        $item_name = strip_tags(trim($_POST['item_name']));
        $category = $_POST['category'];
        $location = strip_tags(trim($_POST['location']));
        $description = strip_tags(trim($_POST['description']));
        $categories = ['Accessories', 'Bags', 'Electronics', 'IDs & Cards', 'Personal Items', 'Other'];

        if ($item_name === '' || $location === '' || !in_array($category, $categories, true) || strlen($item_name) > 255 || strlen($location) > 255 || strlen($description) > 255) {
            $_SESSION['error'] = "Please enter valid item details. Text fields must be 255 characters or fewer.";
            header("Location: $back");
            exit();
        }

        $query = "UPDATE found_items SET item_name = ?, category = ?, description = ?, location_found = ? WHERE found_id = ? AND status = 'Unclaimed'";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('ssssi', $item_name, $category, $description, $location, $found_id);
        $stmt->execute();

        $_SESSION[$stmt->affected_rows > 0 ? 'message' : 'error'] = $stmt->affected_rows > 0
            ? "Found item details updated."
            : "That item is no longer unclaimed.";
        header("Location: $back");
        exit();
    }

?>
