<?php
	use Ntriga\Facebook;
	require_once(__DIR__.'/Facebook.php');

	$social = new Facebook($_GET['app_id'], $_GET['app_secret']);
	$social->savePermanentToken($_POST['fb_account'], $_POST['accesstoken']);

	header('Location: '.$_POST['redirect']);
	die();
?>