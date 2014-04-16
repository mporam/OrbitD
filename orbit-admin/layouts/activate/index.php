<?php
if (!empty($_GET['id'])) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');

	$id =  $_GET['id'];
	
        $query = $con->prepare("UPDATE layout SET active='1' WHERE id=$id;");

	
	try {	
		$query->execute();	
	} catch (PDOException $e) {
		var_dump($e);
	}

        header('Location: /orbit-admin/layouts/');
        exit;

} else {
	header('Location: /orbit-admin/layouts/');
        exit;
}