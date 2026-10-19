<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';
    require_once '../../../config/photoUpload.php';

    // Only Lost and Found staff (Admin) can add or replace photos
    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can upload photos.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    $kind = $_POST['kind'];
    $id = (int) $_POST['id'];

    if ($kind == 'found') {
        $table = 'found_items';
        $idColumn = 'found_id';
        $back = '../../../pages/admin/foundItems.php';
    } else {
        $table = 'lost_items';
        $idColumn = 'report_id';
        $back = '../../../pages/admin/lostReports.php';
    }

    $oldQuery = "SELECT img_path FROM $table WHERE $idColumn = ?";
    $stmt = $connection->prepare($oldQuery);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $old = $stmt->get_result()->fetch_assoc();

    if (!$old || !isset($_FILES['item_image'])) {
        $_SESSION['error'] = "That item could not be found.";
        header("Location: $back");
        exit();
    }

    $image = uploadPhoto($_FILES['item_image']);
    if ($image === false) {
        header("Location: $back");
        exit();
    }

    $updateQuery = "UPDATE $table SET img_path = ? WHERE $idColumn = ?";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param('si', $image, $id);
    $stmt->execute();

    // delete the old photo file
    if (!empty($old['img_path'])) {
        $oldFile = __DIR__ . '/../../../assets/uploads/' . basename($old['img_path']);
        if (is_file($oldFile)) {
            unlink($oldFile);
        }
    }

    $_SESSION['message'] = "Photo updated successfully.";
    header("Location: $back");
    exit();
?>
