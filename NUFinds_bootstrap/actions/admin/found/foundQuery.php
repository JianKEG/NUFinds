<?php 
    require '../../config/connection.php';
    require '../../config/accessController.php';

    // Found items + who claimed them (if claimed)
    $display = "SELECT f.found_id, f.item_name, f.category, f.description, f.location_found, f.date_found, f.img_path, f.status,
                       c.student_name, c.student_id
                FROM found_items f
                LEFT JOIN claim_item c ON f.found_id = c.found_id
                ORDER BY f.date_found DESC, f.found_id DESC";

    $result = mysqli_query($connection, $display);
    $totalRows = mysqli_num_rows($result);
?>
