<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');

if (!empty($_GET['page'])) {
    $pageName = $_GET['page'];
    $query = $con->prepare("SELECT * FROM layout WHERE `name` = '$pageName'");
} else {
    $query = $con->prepare("SELECT * FROM layout WHERE `homepage` = '1'");
}

$query -> execute();
$page = $query->fetch(PDO::FETCH_ASSOC);

if (empty($page)) {
    $query = $con->prepare("SELECT * FROM layout ORDER BY `id`");
    $query -> execute();
    $page = $query->fetch(PDO::FETCH_ASSOC);
}

$query = $con->prepare("SELECT * FROM site_details");
$query -> execute();
$site = $query->fetch(PDO::FETCH_ASSOC);

$title = $page['name'] . " | " . $site['siteName'];

if ($page['homepage']) {
	$title = $site['siteName'];
}

if (!empty($site['keywords'])) {
	$keywords = explode(',',$site['keywords']);
	$title = $title . " | " . implode(' | ', $keywords);
}

if (!empty($page)) {
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $site['siteDesc']; ?>">
    <meta name="keywords" content="<?php echo $site['keywords']; ?>">
    <meta name="site-builder" content="orbitD">
	<link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">

	<link href="/css/core.css" rel="stylesheet" media="screen">
	<link href="/css/generic.css" rel="stylesheet" media="screen">

	<!--[if lt IE 9]>
	  <script src="/js/libraries/html5shiv.js"></script>
	  <script src="/js/libraries/respond.min.js"></script>
	<![endif]-->

    <script src="/js/libraries/jquery-1.10.1.min.js"></script>
    <script src="/js/libraries/bootstrap.min.js"></script>
    <style>
        body {
            background: <?php echo $page['background']; ?>;
        }
        <?php echo $page['head']; ?>
    </style>
</head>
<body>

<?php echo stripslashes($page['content']); ?>

</body>
</html>

<?php 
} else { 
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/errors/404.php');
}