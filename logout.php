<?php
session_start();

$flag = (isset($_SESSION['loggedInEditorId'])) ? true : false;

session_unset();
session_destroy();

if ( $flag ){
	header('location: ./login_admin.php');exit;
}
else{
	header('location: ./login.php');exit;
}

?>