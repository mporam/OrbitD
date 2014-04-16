<?php
if (!empty($_FILES['file'])) {
	
	$tmp = explode(".", $_FILES['file']['name']);
	$ext = end($tmp);
	if (($ext == 'txt' || $ext == 'orbit') && $_FILES['file']['size'] < 20000) {
		
		$result = array();
		
		if ($_FILES['file']['error'] > 0) {
			$result['message'] = $_FILES['file']['error'];
			$result['code'] = 500;
		} else {
			
			// here you actually need to execute the SQL inside the file!
			
			$result['message'] = "success";
			$result['file'] = file_get_contents($_FILES['file']['tmp_name']);
			$result['code'] = 200;
		}
	} else {
		$result['message'] = 'Invalid File';
		$result['code'] = 501;
	}
	header('Content-Type: application/json');
	echo json_encode($result);
}