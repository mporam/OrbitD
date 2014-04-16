<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');        
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');

$query = $con->prepare("SELECT * FROM layout ORDER BY `date_added`");
$query -> execute();
$layouts = $query->fetchAll(PDO::FETCH_ASSOC);

$activeLayouts = array();
$inactiveLayouts = array();

function subarraySort($a, $b) {
  return $a["homepage"] + $b["homepage"]; // need to make sure this actually works!
}

foreach($layouts as $layout) {
    if ($layout['active']) {
        $activeLayouts[] = $layout;
    } else {
        $inactiveLayouts[] = $layout;
    }
}

usort($activeLayouts, "subarraySort");
usort($inactiveLayouts, "subarraySort");

$page = "layouts";
$dashboard = '';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Layouts | OrbitD Admin</title>
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
                    <h3>Layouts</h3>

                    <div class="form-group">
                        <p><strong>Active Layouts</strong>: <?php echo count($activeLayouts); ?></p>
                    </div>

                    <?php if (count($activeLayouts) > 0) { ?>
                    <div id="layouts" class="item-list">
                       <ul>
                       <?php
                           foreach($activeLayouts as $layout) {
                               echo ($layout['homepage'] == '1' ? "<li class='homepage'>" :  "<li>") . $layout['name'] . "<span class='hover-items'><a href='/orbit-admin/layouts/edit/?id=" . $layout['id'] . "'>Edit" . "</a> | <a class='delete' href='/orbit-admin/layouts/delete/?id=" . $layout['id'] . "&deactivate=1'>Deactivate" . "</a></span></li>";
                           }
                       ?>
                       </ul>
               	   </div>
                   <?php } ?>

                    <div class="form-group">
                        <p><strong>Inactive Layouts</strong>: <?php echo count($inactiveLayouts); ?></p>
                    </div>

                    <?php if (count($inactiveLayouts) > 0) { ?>
                    <div id="layouts" class="item-list">
                       <ul>
                       <?php
                           foreach($inactiveLayouts as $layout) {
                               echo ($layout['homepage'] == '1' ? "<li class='homepage'>" :  "<li>") . $layout['name'] . "<span class='hover-items'><a href='/orbit-admin/layouts/activate/?id=" . $layout['id'] . "'>Activate" . "</a> | <a class='delete' href='/orbit-admin/layouts/delete/?id=" . $layout['id'] . "'>Delete" . "</a></span></li>";
                           }
                       ?>
                       </ul>
               	   </div>
                   <?php } ?>

                </div>

            </div>
        </div>



    </div>
</body>
</html>