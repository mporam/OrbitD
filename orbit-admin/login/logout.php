<?php
session_start();
session_destroy();
unset($_COOKIE['orbit-admin']);
setcookie('orbit-admin', null, -1, '/');
header("Location: /orbit-admin/login/");