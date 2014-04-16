<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');      

$query = $con->prepare("SELECT * FROM modules");
$query -> execute();
$modules = $query->fetchAll(PDO::FETCH_ASSOC);

$page = "modules";
$dashboard = '';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Modules | OrbitD Admin</title>
	<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>
    </head>
<body id="modules">
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
                    <h3>Modules</h3>
                    <div class="form-group">
                        <p><strong>Modules</strong>: <?php echo count($modules); ?></p>
                    </div>
                    <div id="modules" class="item-list">
                       <ul>
                       <?php
                           foreach ($modules as $module) {
                              echo "<li>" . $module['name'] . "<span class='hover-items'><a href='/orbit-admin/modules/edit/?id=" . $module['id'] . "'>Edit</a> | <a class='delete' href='/orbit-admin/modules/delete/?id=" . $module['id'] . "'>Delete</a></span></li>";
                           }
                       ?>
                       </ul>
               	   </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="updateModulesModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
        <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-hidden="true"></div>
    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/footerjs.php'); ?>
</body>
</html>