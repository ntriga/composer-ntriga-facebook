<?php
	use Ntriga\Instagram;

	require_once(__DIR__.'/vendor/autoload.php');

	$insta = new Instagram();
	$insta->showLogin();

	echo 'test';
?>