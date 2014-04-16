<?php
if (!empty($_POST)) {
	require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
	$el   =  trim($_POST['element']);
    $type   =  $_POST['type'];
    $size   =  $_POST['size'];
	$name    =  $_POST['name'];
	$headCSS =  trim($_POST['headCSS']);
	$classes =  $_POST['classes'];
	$inlineCSS  =  $_POST['inlineCSS'];
	$content =  trim($_POST['content']);

	if (!empty($_POST['id'])) {
		$id=  $_POST['id'];
		$query = $con->prepare("UPDATE modules SET `name`='$name', `headCSS`='$headCSS', `classes`='$classes', `element`='$el', `type`='$type', `size`='$size', `inlineCSS`='$inlineCSS', `content`='$content' WHERE `id` = $id");
	} else {
		$query = $con->prepare("INSERT INTO modules (`name`, `headCSS`, `classes`, `element`, `type`, `size`, `inlineCSS`, `content`) VALUES ('$name', '$headCSS', '$classes', '$el', '$type', '$size',  '$inlineCSS', '$content')");
	}

	try {	
		$query->execute();
	} catch (PDOException $e) {
		$result = array(
			code => 500,
			message => 'Save Failed, please try again'
		);
		die(json_encode($result));
	}
	
	if (empty($_POST['id'])) {
		$lastid = $con->lastInsertId();
	} else {
		$lastid = $_POST['id'];
	}
	$result = array(
		code => 200,
		message => 'Module Saved',
		id => $lastid
	);
	
	echo json_encode($result);

} else {
	die(json_encode(array(message => 'Internal Server Error', code => 500)));
}