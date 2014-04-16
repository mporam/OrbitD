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
                if (!empty($_GET['login'])) {
                    if ($_GET['login'] == 'failed') {
                        echo "<div class='alert alert-danger'>Incorrect username or password, please try again</div>";
                    }

                    if ($_GET['login'] == 'false') {
                        echo "<div class='alert alert-warning'>Please provide a username and password</div>";
                    }

                } ?>
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
                      <div class="col-sm-offset-3 col-sm-9">
                          <div class="checkbox">
                          <label>
                              <input type="checkbox" name="remember"> Remember me
                          </label>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                      <button type="submit" class="btn btn-primary">Sign in</button>
                  </div>
              </div>
          </form>
        </div>

    </div>
</body>
</html>