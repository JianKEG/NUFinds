<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';

    $back = '../../../pages/admin/foundItems.php';

    // Only Lost and Found staff (Admin) can mark items as claimed
    if (!$isAdmin) {
        $_SESSION['error'] = "Only Lost and Found staff can mark items as claimed.";
        header('Location: ../../../pages/admin/dashboard.php');
        exit();
    }

    if (isset($_POST['claimForm'])) {
        $found_id = (int) $_POST['found_id'];
        $student_name = strip_tags(trim($_POST['student_name']));
        $student_id = strip_tags(trim($_POST['student_id']));
        $email = trim($_POST['email']);

        if ($student_name == '' || $student_id == '' || $email == '' || strlen($student_id) > 12 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Please enter the claimant's name, a student ID (12 characters max), and a valid email.";
            header("Location: $back");
            exit();
        }

        try {
            $connection->begin_transaction();

            // only items that are still Unclaimed can be claimed
            $updateQuery = "UPDATE found_items SET status = 'Claimed' WHERE found_id = ? AND status = 'Unclaimed'";
            $stmt = $connection->prepare($updateQuery);
            $stmt->bind_param('i', $found_id);
            $stmt->execute();

            if ($stmt->affected_rows == 0) {
                $connection->rollback();
                $_SESSION['error'] = "That item is no longer unclaimed.";
                header("Location: $back");
                exit();
            }

            $insertQuery = "INSERT INTO claim_item (found_id, student_id, student_name, email, claim_date) VALUES (?, ?, ?, ?, CURDATE())";
            $stmt = $connection->prepare($insertQuery);
            $stmt->bind_param('isss', $found_id, $student_id, $student_name, $email);
            $stmt->execute();

            $connection->commit();
            $_SESSION['message'] = "Item marked as claimed.";
        } catch (mysqli_sql_exception $e) {
            $connection->rollback();
            $_SESSION['error'] = "Could not save the claim. Please try again.";
        }

        header("Location: $back");
        exit();
    }
?>
