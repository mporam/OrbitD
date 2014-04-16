<?php
if (!empty($_POST)) {
    if (!empty($_POST['siteName']) && !empty($_POST['domain'])) {

		require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
	
		$siteName  =  $_POST['siteName'];
		$domain     =  $_POST['domain'];
		$keywords  = rtrim($_POST['keywords'], ',');
		$siteDesc    =  trim($_POST['siteDesc']);
	
		$query = $con->prepare("REPLACE INTO site_details (`id`, `siteName`, `domain`, `keywords`, `siteDesc`) VALUES (1, '$siteName', '$domain', '$keywords', '$siteDesc');");
		
		try {
			$query->execute();
		} catch (PDOException $e) {
			die(json_encode(array(message => 'Save failed, please try again', code => 500)));
		}
		
		$result = array(
			code => 200,
			message => 'Details Saved'
		);
		echo json_encode($result);
		
    } else {
        die(json_encode(array(message => 'Save failed, data incomplete', code => 501)));
    }

} else {
	die(json_encode(array(message => 'Save failed, please try again', code => 500)));
}