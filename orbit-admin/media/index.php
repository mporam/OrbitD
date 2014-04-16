<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');
$page = "media";
$dashboard = '';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Media | OrbitD Admin</title>
	<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>
        <script>
            function openKCFinder_multipleFiles() {
    window.KCFinder = {};
    window.KCFinder.callBackMultiple = function(files) {
        for (var i; i < files.length; i++) {
            // Actions with files[i] here
        }
        window.KCFinder = null;
    };
    window.open('kcfinder/browse.php', 'kcfinder_multiple');
}
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
                    <h3>Media</h4>
                    <p>Here we will show the file manager for uploading and managing images</p>
                    <iframe src="http://www.orbitd.co.uk/orbit-admin/media/kcfinder/browse.php" width="100%" height="500">

            </div>
        </div>



    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/footerjs.php'); ?>
</body>
</html>