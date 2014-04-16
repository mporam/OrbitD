<?php 
session_start();

if(empty($_SESSION)) {
    session_destroy();
    header("Location: /orbit-admin/login/");
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

$query = $con->prepare("SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password'");
$query -> execute();
$check = $query->fetch(PDO::FETCH_ASSOC);

if (empty($check)) {
    session_destroy();
    header("Location: /orbit-admin/login/?login=failed");
} else {
    $_SESSION['KCFINDER'] = array();
    $_SESSION['KCFINDER']['disabled'] = false;
}