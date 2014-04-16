<?php
if (!empty($_POST)) {
    if (!empty($_POST['name']) && !empty($_POST['content'])) {

		require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
	
		$background =  $_POST['background'];
		$container  =  $_POST['container'];
		$content    =  trim($_POST['content']);
		$head       =  trim($_POST['head']);
		$js         =  trim($_POST['js']);
		$name       =  $_POST['name'];
		$homepage   =  $_POST['homepage'];
		$active     = $_POST['active'];
		
	
		if (!empty($_POST['id'])) {
			$id = $_POST['id'];
			$query = $con->prepare("UPDATE layout SET `name`='$name', `content`='$content', `head`='$head', `script`='$js', `container`=$container, `background`= '$background', `homepage`=$homepage WHERE `id` = $id");
		} else {
			$query = $con->prepare("INSERT INTO layout (`name`, `content`, `head`, `script`, `container`, `background`, `active`, `homepage`) VALUES ('$name', '$content', '$head', '$js', $container, '$background', $active, $homepage)");
		}
		
		try {
			$query->execute();
		} catch (PDOException $e) {
			die(json_encode(array(message => 'Save failed, please try again', code => 500)));
		}
		
		if (empty($_POST['id'])) {
			$lastID = $con->lastInsertId();
		} else {
			$lastID = $_POST['id'];
		}
		$result = array(
			code => 200,
			message => 'Page Saved',
			id => $lastID
		);
		if (!$active) $result['message'] = 'Page saved as draft';
		echo json_encode($result);
		
    } else {
        die(json_encode(array(message => 'Save failed, data incomplete', code => 501)));
    }

} else {
	die(json_encode(array(message => 'Save failed, please try again', code => 500)));
}