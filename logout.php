<?php
session_start();
if(isset($_SESSION['SESS_USERID'])){
	unset($_SESSION['SESS_USERID']);
}

if(isset($_SESSION['SESS_USERNAME'])){
	unset($_SESSION['SESS_USERNAME']);
}

session_destroy();
header('location:index.php');
exit();
?>