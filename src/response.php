<?php
	$request_body = file_get_contents('php://input');
	$response = json_decode($request_body);
	if (isset($response->authResponse)) {
		file_put_contents(__DIR__.'/../settings/facebook_key.json', json_encode($response->authResponse));
	}
?>