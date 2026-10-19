<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require '../../../config/accessControllerActions.php';
    require_once '../../../config/connection.php';
    require_once '../../../config/photoUpload.php';

    $back = '../../../pages/admin/postItem.php';

    if (isset($_POST['createForm'])) {
        $item_type = $_POST['item_type'];
        $item_name = strip_tags(trim($_POST['item_name']));
        $category = $_POST['category'];
        $location = strip_tags(trim($_POST['location']));
        $date = $_POST['item_date'];
        $description = strip_tags(trim($_POST['description']));

        // Utility / Guard staff can only post found items
        if (!$isAdmin) {
            $item_type = 'Found';
        }

        $categories = ['Accessories', 'Bags', 'Electronics', 'IDs & Cards', 'Personal Items', 'Other'];

        if ($item_name == '' || $location == '' || $date == '' || !in_array($category, $categories)) {
            $_SESSION['error'] = "Please fill in the item name, category, location, and date.";
            header("Location: $back");
            exit();
        }

        if ($date > date('Y-m-d')) {
            $_SESSION['error'] = "The date cannot be in the future.";
            header("Location: $back");
            exit();
        }

        if (strlen($item_name) > 255 || strlen($location) > 255 || strlen($description) > 255) {
            $_SESSION['error'] = "Item name, location, and description must be 255 characters or fewer.";
            header("Location: $back");
            exit();
        }

        // Photo: only Lost and Found staff (Admin) can upload
        $image = null;
        if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if (!$isAdmin) {
                $_SESSION['error'] = "Only Lost and Found staff can upload photos.";
                header("Location: $back");
                exit();
            }

            $image = uploadPhoto($_FILES['item_image']);
            if ($image === false) {
                header("Location: $back");
                exit();
            }
        }

        if ($item_type == 'Found') {
            $insertQuery = "INSERT INTO found_items (item_name, category, description, location_found, date_found, img_path) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($insertQuery);
            $stmt->bind_param('ssssss', $item_name, $category, $description, $location, $date, $image);
            $stmt->execute();

            $_SESSION['message'] = "Found item posted successfully.";
        } else {
            // Lost report: student name, ID, and email are required
            $student_name = strip_tags(trim($_POST['student_name']));
            $student_id = strip_tags(trim($_POST['student_id']));
            $email = trim($_POST['email']);

            if ($student_name == '' || $student_id == '' || $email == '') {
                $_SESSION['error'] = "Student name, student ID, and email are required for Lost reports.";
                header("Location: $back");
                exit();
            }


            if (strlen($student_id) !== 12) {
                $_SESSION['error'] = "Student ID must be 12 characters.";
                header("Location: $back");
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Please enter a valid email address.";
                header("Location: $back");
                exit();
            }

            $insertQuery = "INSERT INTO lost_items (item_name, category, description, location_lost, date_lost, student_id, student_name, email, date_reported, img_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), ?)";
            $stmt = $connection->prepare($insertQuery);
            $stmt->bind_param('sssssssss', $item_name, $category, $description, $location, $date, $student_id, $student_name, $email, $image);
            $stmt->execute();

            $_SESSION['message'] = "Lost report logged successfully.";
        }

        header("Location: $back");
        exit();
    }
?>
