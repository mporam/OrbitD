<?php
$loc = '/orbit-admin/modules/';
if (!empty($_GET['ref']) && $_GET['ref'] == 'nav') $loc =  '/orbit-admin/navs/';

if (!empty($_GET['id'])) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');

        if (is_string($_GET['id'])) {
            $id =  $_GET['id'];
            $query = $con->prepare("DELETE FROM modules WHERE id=$id;");
        } else {
            // allow for multiple deletions
            header('Location: /orbit-admin/modules/');
            exit;
        }
	
	try {	
		$query->execute();	
	} catch (PDOException $e) {
		var_dump($e);
	}

        header('Location: ' . $loc);
        exit;

} else {
	header('Location: ' . $loc);
        exit;
}