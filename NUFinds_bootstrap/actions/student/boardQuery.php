<?php
       // Public board: student details remain private while item details are public.
    require_once __DIR__ . '/../../config/connection.php';

       $board = "SELECT found_id AS id, 'found' AS kind, item_name, category, description, location_found AS location,
                     date_found AS item_date, img_path,
                     IF(status = 'Unclaimed', 'Found', 'Claimed') AS board_status
              FROM found_items
              WHERE status IN ('Unclaimed', 'Claimed')
              UNION ALL
              SELECT report_id AS id, 'lost' AS kind, item_name, category, description,
                     IFNULL(location_lost, 'an unknown location') AS location,
                     IFNULL(date_lost, date_reported) AS item_date, img_path,
                     'Lost' AS board_status
              FROM lost_items
              WHERE status = 'Open'
              ORDER BY item_date DESC, id DESC";

    $boardResult = mysqli_query($connection, $board);
?>
