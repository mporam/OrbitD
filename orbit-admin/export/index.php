<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');

$page = "export";
$dashboard = '';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Import/Export | OrbitD Admin</title>
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
                <h3>Import Site</h3>
				<p>Use the below form to select the file you have exported from OrbitD.<br><strong>Note: OrbitDeveloper exports may not import into OrbitDesigner as expected</strong></p>
                <form method="POST" action="import.php" enctype="multipart/form-data">
                	<div class="form-group">
                    	<label>Site Import:</label>
                        <input type="file" name="file" />
                    </div>
                    <input type="submit" value="Import" class="btn btn-primary">
                </form>
                
                <h3>Export Site</h3>
        </div>



    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/footerjs.php'); ?>
</body>
</html>