<?php 
    require '../../config/connection.php';
    require '../../config/accessController.php';

    $page_title = "Dashboard";

    // found items
    $unclaimedCount = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) as total FROM found_items WHERE status = 'Unclaimed'"))['total'];
    $claimedCount   = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) as total FROM found_items WHERE status = 'Claimed'"))['total'];
    $disposedCount  = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) as total FROM found_items WHERE status = 'Disposed'"))['total'];
    $totalFoundCount = $unclaimedCount + $claimedCount + $disposedCount;

    // lost reports
    $openLostCount = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) as total FROM lost_items WHERE status = 'Open'"))['total'];

    // recent found items
    $recentQuery = "SELECT found_id, item_name, location_found, date_found, img_path, status FROM found_items ORDER BY date_found DESC, found_id DESC LIMIT 5";
    $recentResult = mysqli_query($connection, $recentQuery);
?>
