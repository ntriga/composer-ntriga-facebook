<?php
	use Ntriga\Instagram;
	use Ntriga\Facebook;
	require_once(__DIR__.'/Facebook.php');
	require_once(__DIR__.'/Instagram.php');

	if (isset($_GET['platform'])) {
		if ($_GET['platform'] == 'instagram') {
			$social = new Instagram($_GET['app_id'], $_GET['app_secret']);
		}else{
			$social = new Facebook($_GET['app_id'], $_GET['app_secret']);
		}
		$social->savePermanentToken($_POST['fb_account'], $_POST['accesstoken']);
	}

	header('Location: '.$_POST['redirect']);
	die();
?>