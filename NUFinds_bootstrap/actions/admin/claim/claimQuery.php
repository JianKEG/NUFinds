<?php 
    require '../../config/connection.php';
    require '../../config/accessController.php';

    $display = "SELECT c.claim_id, c.student_id, c.student_name, c.email, c.claim_date,
                       f.item_name, f.category
                FROM claim_item c
                INNER JOIN found_items f ON c.found_id = f.found_id
                ORDER BY c.claim_date DESC, c.claim_id DESC";

    $result = mysqli_query($connection, $display);
    $totalRows = mysqli_num_rows($result);
?>
