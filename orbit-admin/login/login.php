<?php 
session_start();
if(isset($_POST['username'])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $con->prepare("SELECT `salt` FROM users WHERE `username` = '$username'");
    $query -> execute();
    $salt = $query->fetchColumn();

    if (empty($salt)) {
        session_destroy();
	header("Location: /orbit-admin/login/?login=failed");
        exit;
    }

    $password = sha1($password . $salt);

    $query = $con->prepare("SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password'");
    $query -> execute();
    $_SESSION = $query->fetch(PDO::FETCH_ASSOC);

    if (empty($_SESSION)) {
		session_destroy();
		header("Location: /orbit-admin/login/?login=failed");
                exit;
    }

    $_SESSION['KCFINDER'] = array();
    $_SESSION['KCFINDER']['disabled'] = false;

    if ($_POST['remember']) {
        $value = array(
            'username' => $_SESSION['username'],
            'password' => $_SESSION['password']
        );
	$expiry = time()+(365 * 24 * 60 * 60);
        setcookie("orbit-admin", json_encode($value), $expiry);
    }

    $query = $con->prepare("SELECT * FROM site_details");
    $query -> execute();
    $_SESSION['site_details'] = $query->fetch(PDO::FETCH_ASSOC);

    header("Location: /orbit-admin/");
} else {
	session_destroy();
	header("Location: /orbit-admin/login/?login=false");
}