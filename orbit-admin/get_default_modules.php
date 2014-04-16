<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
	$query = $con->prepare("SELECT * FROM default_modules");
	$query -> execute();
	$default_modules = $query->fetch();
	
	echo json_encode($default_modules);