<?php
session_start();
$_SESSION['role'] = 'guest';
$_SESSION['username'] = 'Guest';
header("Location: dashboard.php");
exit();
