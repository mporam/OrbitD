<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');

$query = $con->prepare("SELECT * FROM modules");
$query -> execute();
$modules = $query->fetchAll(PDO::FETCH_ASSOC);           

$query = $con->prepare("SELECT * FROM layout");
$query -> execute();
$layouts = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $con->prepare("SELECT * FROM site_details");
$query -> execute();
$siteDetails = $query->fetch(PDO::FETCH_ASSOC);

if (empty($siteDetails)) {
	$siteDetails = array();
}

$page = "dashboard";
$dashboard = '';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | OrbitD Admin</title>
	<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>

    <script src="/js/libraries/bootstrap.min.js"></script>
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
                    <h3>OrbitD - Dashboard</h3>
                    <div class="col-md-4">
                    	<h4>Site Details</h4>
                        <form id="site-details">
                        <div class="form-group">
                            <label for="siteName">Site name:</label>
                            <input type="text" name="siteName" class="form-control" id="siteName" placeholder="Please define your site name" value="<?php echo $siteDetails['siteName'];  ?>">
                        </div>
                        <div class="form-group">
                            <label for="keywords">Keywords:</label>
                            <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Type each keyword here and press enter">
                            <div class="keywords">
                            <?php
								$keywords = explode(",", $siteDetails['keywords']);
								foreach ($keywords as $keyword) {
									echo "<button type='button' class='btn'>" . $keyword . "</button>";
								}
							?>
                            </div>                        
                        </div>
                        <div class="form-group">
                            <label for="siteDesc">Site Description:</label>
                            <textarea name="siteDesc" class="form-control" id="siteDesc"><?php echo $siteDetails['siteDesc']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="domain">Domain:</label>
                            <input type="text" name="domain" class="form-control" id="domain" placeholder="Please define your website domain" value="<?php echo $siteDetails['domain'];  ?>">
                        </div>
                        <input type="submit" value="Save" class="btn btn-primary">
                        </form>
                    </div>

                    <div id="layouts" class="item-list col-md-4">
                       <h4>Layouts (<?php echo count($layouts); ?>)</h4>
                       <ul>
                           <?php
                               foreach($layouts as $layout) {
                                   if ($layout['homepage'] == '1') {
                                       echo "<li class='homepage'>" . $layout['name'] . "</li>";
                                   } else {
                                       echo "<li>" . $layout['name'] . "</li>";
                                   }
                               }
                           ?>
                       </ul>
                   </div>
    
                    <div id="modules" class="item-list col-md-4">
                       <h4>Modules (<?php echo count($modules); ?>)</h4>
                       <ul>
                           <?php
                               foreach($modules as $module) {
                                   echo "<li>" . $module['name'] . "</li>";
                               }
                           ?>
                       </ul>
                   </div>
                   
				</div>
            </div>
        </div>



    </div>
    <script src="/js/admin/site-details.js"></script>
</body>
</html>