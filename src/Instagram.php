<?php

namespace Ntriga;

class Instagram
{
	private $response_url = '';
	private $page_key_file = __DIR__.'/../settings/instagram_page_key.json';

	private $app_id = 0;
	private $app_secret = '';

	function __construct($app_id = 213575729318742, $app_secret = 'a611ecce8716dd5e1d2d8cad2480a154'){
		$this->app_id = $app_id;
		$this->app_secret = $app_secret;
		$this->response_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__).'/response.php?platform=instagram';
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
		return json_decode(file_get_contents('https://graph.facebook.com/v5.0/oauth/access_token?grant_type=fb_exchange_token&client_id='.$this->app_id.'&client_secret='.$this->app_secret.'&fb_exchange_token='.$user_token));
	}

	public function getPermanentToken($page_id, $token){
		return json_decode(file_get_contents('https://graph.facebook.com/v5.0/'.$page_id.'?fields=access_token&access_token='.$token));
	}

	public function getBusinessId($page_id, $token){
		return json_decode(file_get_contents('https://graph.facebook.com/v5.0/'.$page_id.'?fields=instagram_business_account&access_token='.$token));
	}

	public function savePermanentToken($page_id, $user_token){
		$long_token = $this->getLongLivedToken($user_token);
		$permanent_token = $this->getPermanentToken($page_id, $long_token->access_token);
		$business = $this->getBusinessId($page_id, $permanent_token->access_token);

		file_put_contents($this->page_key_file, json_encode(['business_id' => $business->instagram_business_account->id, 'access_token' => $permanent_token->access_token, 'page_id' => $page_id]));

		return true;
	}

	public function getPosts(){
		$settings = json_decode(file_get_contents($this->page_key_file));
		return json_decode(file_get_contents('https://graph.facebook.com/v5.0/'.$settings->business_id.'/media?fields=media_url,caption,comments_count,like_count,media_type,thumbnail_url,timestamp,comments,permalink&limit=50&access_token='.$settings->access_token));
	}

}
