<?php
	require __DIR__ . '/constant.php';
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (!$connection) {
		die("could not connect" . mysqli_connect_error());
	}
?>
