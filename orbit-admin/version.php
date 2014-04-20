<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');
$page = "version";
$version = "0.9.0";
$versionInfo = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/versions.json");
$versionInfo = json_decode($versionInfo, true);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Version <?php echo $version; ?> | Orbit Admin</title>
	<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>
    <script>
		var version = '<?php echo $version; ?>',
			message = "";
	    $(function() {
			$.getJSON("http://orbitD.co.uk/versions.json").done(function(data) {
				$('#latest').text(data.versions.latest);
				$('#previous').text(data.versions.previous);
				if (data.versions.latest == version) {
					message = "You are using the latest version of OrbitD, check back later for all the latest features and updates.";
				} else if (data.versions.previous == version) {
					message = "You are using the previous version of OrbitD, <a href='orbitd.co.uk' target='_blank'>update now</a> for all the latest features and fixes!";
				} else {
					message = "You are using an old version of OrbitD, please <a href='orbitd.co.uk' target='_blank'>update now</a>.";
				}
				$('#message').html(message);
			});
		});
	</script>
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
                <p>The latest version is <span id="latest"></span></p>
                <p>The previous version is <span id="previous"></span></p>
                <p id="message"></p>
            </div>
        </div>
    </div>
</body>
</html>