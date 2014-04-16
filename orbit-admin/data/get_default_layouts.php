<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
	$query = $con->prepare("SELECT * FROM default_layouts");
	$query -> execute();
	$default_layouts= $query->fetchAll(PDO::FETCH_ASSOC);
	
	header('Content-Type: application/json');
	echo json_encode($default_layouts);