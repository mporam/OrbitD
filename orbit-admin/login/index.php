<?php
    if (!empty($_COOKIE['orbit-admin'])) {
        session_start();
        $cookie = json_decode(stripslashes($_COOKIE['orbit-admin']));
        $_SESSION['username'] = $cookie->username;
        $_SESSION['password'] = $cookie->password;
        header("Location: /orbit-admin/");
    };
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | OrbitD Admin</title>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/orbit-admin/includes/head.php'); ?>
</head>
<body>
    <div id="template-builder">

        <div class="col-sm-6" id="login-form">
            <img src="/img/logo.png" alt="OrbitD">

           <?php 
                 if (!empty($_GET['action']) && $_GET['action'] == 'pwreset') { 
                    if (!empty($_GET['user'])) {
                        if ($_GET['user'] == 'invalid') {
                            echo "<div class='alert alert-danger'>That email address is not registered on our system, please try again.</div>";
                        } else if ($_GET['user'] == 'valid') {
                            echo "<div class='alert alert-success'>Your password reset email has been sent, please click the link provided in the email.</div>";
                        }
                    }
             ?>
                <div class="alert alert-info">Please enter your email address. You will receive a link to create a new password via email.</div>
                <form class="form-horizontal" role="form" action="/orbit-admin/login/reset.php" method="POST">
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input required type="text" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                  </div>
                  
              <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="btn btn-primary">Reset Password</button>
                  </div>
              </div>
          </form>


           <?php
            } else if (!empty($_GET['reset'])) {
				require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
			    $reset = $_GET['reset'];
				$query = $con->prepare("SELECT `id` FROM users WHERE `reset` = '$reset'");
				$query -> execute();
				$id = $query->fetchColumn();
				
				if (empty($id)) {header('Location: /orbit-admin/login/?action=pwreset'); exit; } ?>
				
				<div class="alert alert-info">Reset your password below</div>
                <form class="form-horizontal" role="form" action="/orbit-admin/login/reset.php?reset=<?php echo $reset; ?>" method="POST">
                <div class="form-group">
                    <label for="Npassword" class="col-sm-4 control-label">New Password</label>
                    <div class="col-sm-8">
                        <input required type="password" name="Npassword" class="form-control" id="Npassword" value="">
                    </div>
                  </div>
                  
              <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
              </div>
          </form>
	
		<?php
			} else {

                if (!empty($_GET['login'])) {
                    if ($_GET['login'] == 'failed') {
                        echo "<div class='alert alert-danger'>Incorrect username or password, please try again</div>";
                    }

                    if ($_GET['login'] == 'false') {
                        echo "<div class='alert alert-warning'>Please provide a username and password</div>";
                    }

                }
				if ($_GET['pwreset'] == "true") {
					echo "<div class='alert alert-success'>Password successfully reset, you can now login below</div>";
				}
				if ($_GET['pwreset'] == "false") {
					echo "<div class='alert alert-danger'>Password reset failed, please try again.</div>";
				}
				 ?>
            <form class="form-horizontal" role="form" action="/orbit-admin/login/login.php" method="POST">
                <div class="form-group">
                    <label for="inputUser" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input required type="text" name="username" class="form-control" id="inputUser" placeholder="Username">
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="inputPassword" class="col-sm-3 control-label">Password</label>
                      <div class="col-sm-9">
                          <input required type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-4">
                          <div class="checkbox">
                          <label>
                              <input type="checkbox" name="remember"> Remember me
                          </label>
                      </div>
                  </div>
                  <div class="checkbox col-sm-5">
                      <a href="?action=pwreset">Forgotten your password?</a>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="btn btn-primary">Sign in</button>
                  </div>
              </div>
          </form>
          <?php } ?>
        </div>

    </div>
</body>
</html>