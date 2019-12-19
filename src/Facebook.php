<?php

namespace Ntriga;

class Facebook
{
	private $response_url = '';
	private $page_key_file = __DIR__.'/../settings/facebook_page_key.json';

	private $app_id = 0;
	private $app_secret = '';

	private $api_url = 'https://graph.facebook.com/v5.0/';

	function __construct($app_id = null, $app_secret = null){
		$this->app_id = $app_id;
		$this->app_secret = $app_secret;
		$this->response_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__).'/response.php?platform=facebook&app_id='.$app_id.'&app_secret='.$app_secret;
	}

	public function showLogin(){
		$login_html = file_get_contents(__DIR__.'/facebook_login.html');
		echo str_replace('[[app_id]]', $this->app_id, str_replace('[[response_post_url]]', $this->response_url , str_replace('[[response_redirect_url]]', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", $login_html) ));
	}

	public function checkPageKey(){
		if (file_exists($this->page_key_file)) {
			return true;
		}else{
			return false;
		}
	}

	public function getLongLivedToken($user_token){
		return json_decode(file_get_contents($this->api_url.'oauth/access_token?grant_type=fb_exchange_token&client_id='.$this->app_id.'&client_secret='.$this->app_secret.'&fb_exchange_token='.$user_token));
	}

	public function getPermanentToken($page_id, $token){
		return json_decode(file_get_contents($this->api_url.$page_id.'?fields=access_token&access_token='.$token));
	}

	public function savePermanentToken($page_id, $user_token){
		$long_token = $this->getLongLivedToken($user_token);
		$permanent_token = $this->getPermanentToken($page_id, $long_token->access_token);

		file_put_contents($this->page_key_file, json_encode(['access_token' => $permanent_token->access_token, 'page_id' => $page_id]));

		return true;
	}

	public function getPosts(){
		$settings = json_decode(file_get_contents($this->page_key_file));
		return json_decode(file_get_contents($this->api_url.$settings->page_id.'/feed?fields=full_picture,created_time,id,message,permalink_url&limit=50&access_token='.$settings->access_token));
	}

}
