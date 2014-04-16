<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
	$query = $con->prepare("SELECT * FROM layout WHERE `active` = 1");
	$query -> execute();
	$saved_layouts = $query->fetchAll(PDO::FETCH_ASSOC);
	header('Content-Type: application/json');
	echo json_encode($saved_layouts);