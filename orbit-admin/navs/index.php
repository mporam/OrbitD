<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');      

$query = $con->prepare("SELECT * FROM modules WHERE type = 'navigation'");
$query -> execute();
$navs = $query->fetchAll(PDO::FETCH_ASSOC);

$page = "navs";
$dashboard = '';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Navigations | OrbitD Admin</title>
	<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>
        <script> var navs = <?php echo json_encode($navs); ?>; </script>
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
            <div id="notifications"></div>
            <div id="main">

                <div id="overview" class="dash-box col-sm-6">
                    <h3>Navigations</h3>
                    <div class="form-group">
                        <p><strong>Navigations</strong>: <?php echo count($navs); ?></p>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-info" id="create-nav">Create Nav</button>
                    </div>
                    <div id="navs" class="item-list">
                       <ul>
                       <?php
                           foreach ($navs as $nav) {
                              echo "<li data-id='" . $nav['id'] . "'>" . $nav['name'] . "<span class='hover-items'><a class='delete' href='/orbit-admin/modules/delete/?id=" . $nav['id'] . "&ref=nav'>Delete</a></span></li>";
                           }
                       ?>
                       </ul>
               	   </div>
                </div>

                <div class="col-sm-6">
                    <h3>Quick Preview</h3>
                    <div id="quickPreview">
                    Hover over a navigation on the left to view here
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="updateModules" tabindex="-1" role="dialog" aria-hidden="true"></div>
        <div class="modal fade" id="navModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
        <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-hidden="true"></div>
    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/footerjs.php'); ?>
    <script src="/js/admin/navigation-builder.js"></script>
</body>
</html>