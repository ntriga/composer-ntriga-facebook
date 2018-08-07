<?php
	use Ntriga\Instagram;

	require_once(__DIR__.'/vendor/autoload.php');

	$insta = new Instagram(879710678749485);
	//$insta->showLogin();

	$insta->getPosts();
?>