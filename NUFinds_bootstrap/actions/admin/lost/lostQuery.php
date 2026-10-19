<?php 
    require '../../config/connection.php';
    require '../../config/accessController.php';

    $display = "SELECT report_id, item_name, category, location_lost, date_lost, student_id, student_name, email, date_reported, img_path, status
                FROM lost_items
                ORDER BY date_reported DESC, report_id DESC";

    $result = mysqli_query($connection, $display);
    $totalRows = mysqli_num_rows($result);
?>
