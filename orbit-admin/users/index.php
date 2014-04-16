<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/login/accountCheck.php');

$query = $con->prepare("SELECT * FROM users");
$query -> execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

$page = "users";
$dashboard = '';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | Users | OrbitD Admin</title>
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
                <h3>Users</h3>
                <div class="alert alert-warning">
                    <p>As a OrbitDesigner customer you can only have one registered user, for additional user accounts please upgrade to OrbitDeveloper</p>
                </div>

                <p>Registered users:</p>
                <table width="100%" class="item-list">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Permissions</th>
                    </tr>
                    <?php foreach($users as $user) { ?>
                    <tr>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['access']; ?><span class="hover-items pull-right"><a href="/orbit-admin/users/edit/?id=<?php echo $user['id']; ?>">Edit User</a></span></td>
                    </tr>
                    <?php } ?>
                </table> 
        </div>



    </div>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/footerjs.php'); ?>
</body>
</html>