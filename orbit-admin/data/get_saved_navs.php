<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
	$query = $con->prepare("SELECT * FROM modules WHERE type = 'navigation'");
	$query -> execute();
	$saved_navs = $query->fetchAll(PDO::FETCH_ASSOC);

	header('Content-Type: application/json');
	echo json_encode($saved_navs);