<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/sql/db_con.php');
if (!empty($_POST['email'])) {
    require($_SERVER['DOCUMENT_ROOT'] . "/includes/phpmailer/class.phpmailer.php");

    $email = $_POST['email'];

    $query = $con->prepare("SELECT `salt` FROM users WHERE `email` = '$email'");
    $query -> execute();
    $salt = $query->fetchColumn();

    if (empty($salt)) {header('Location: /orbit-admin/login/?action=pwreset&user=invalid'); exit; }

    $reset = sha1($email . $salt);
    $query = $con->prepare("UPDATE users SET `reset`='$reset' WHERE `email` = '$email'");

    try {	
        $query->execute();
    } catch (PDOException $e) {
        header('Location: /orbit-admin/login/?action=pwreset&user=invalid'); exit;
    }

$message = "Hi,

Please click the below link to reset your password:
http://" . $_SERVER['HTTP_HOST'] . "/orbit-admin/login/?reset=" . $reset . "

If you did not request a password reset please ignore this email.

OrbitD";

    $mail = new PHPMailer();
    $mail->IsSMTP();  // telling the class to use SMTP
    $mail->Host     = "10.168.1.70"; // SMTP server
    $mail->SetFrom("reset@orbitD.co.uk", 'OrbitD Password Reset');
    $mail->AddAddress($email);
    $mail->Subject  = 'OrbitD Password Reset';
    $mail->Body     = $message;
    $mail->WordWrap = 78;

    if($mail->Send()) {   
        header('Location: /orbit-admin/login/?action=pwreset&user=valid'); exit;
    } else {
        header('Location: /orbit-admin/login/?action=pwreset'); exit;
    }

} else if (!empty($_GET['reset']) && !empty($_POST['Npassword'])) {

    $reset = $_GET['reset'];
	$password = $_POST['Npassword'];
	$query = $con->prepare("SELECT `id` FROM users WHERE `reset` = '$reset'");
	$query -> execute();
	$id = $query->fetchColumn();
	
	if (empty($id)) {header('Location: /orbit-admin/login/?action=pwreset'); exit; }
	
	$query = $con->prepare("SELECT `salt` FROM users WHERE `reset` = '$reset'");
	$query -> execute();
	$salt = $query->fetchColumn();
	
	$password = sha1($password . $salt);
	
	$query = $con->prepare("UPDATE users SET `password` = '$password', `reset`=NULL WHERE `id` = $id");
	try {	
        $query->execute();
    } catch (PDOException $e) {
        header('Location: /orbit-admin/login/?pwreset=true'); exit;
    }

	header('Location: /orbit-admin/login/?pwreset=true');

} else {
    header('Location: /orbit-admin/login/');
    exit;
}