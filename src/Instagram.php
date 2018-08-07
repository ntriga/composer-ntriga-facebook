<?php

namespace Ntriga;

class Instagram
{
	private $response_url = '';

	function __construct(){
		$this->response_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__).'/response.php';
	}

	public function showLogin(){
		$login_html = file_get_contents(__DIR__.'/facebook_login.html');
		echo str_replace('[[response_post_url]]', $this->response_url , $login_html);
	}


}
