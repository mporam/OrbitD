<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');
$page = "version";
$version = "0.2.2";
$versionInfo = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/versions.json");
$versionInfo = json_decode($versionInfo, true);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Version <?php echo $version; ?> | Orbit Admin</title>
	<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>
    </head>
<body>
<div id="template-builder">
        <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/topbar.php'); ?>

        <div class="sidebar">
            <div class="sidebar-inner">
                <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/admin-nav.php'); ?>
            </div>
        </div>

        <div id="builder" class="col-sm-10">
            <div id="main">

                <div id="overview" class="dash-box">
                    <h3>Version</h3>
                    <p>You are currently using <strong>version <?php echo $version; ?></strong>.</p>
                    <p>The latest version is <?php echo $versionInfo["versions"]["latest"]; ?></p>
            </div>
        </div>



    </div>
</body>
</html>