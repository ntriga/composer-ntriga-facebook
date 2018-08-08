<?php
	use Ntriga\Instagram;
	require_once(__DIR__.'/Instagram.php');

	$insta = new Instagram();
	$insta->savePermanentToken($_POST['fb_account'], $_POST['accesstoken']);

	header('Location: '.$_POST['redirect']);
	die();
?>