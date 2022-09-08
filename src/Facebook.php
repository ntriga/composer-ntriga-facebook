<?php

namespace Ntriga;

class Facebook
{
	private $response_url = '';

	private $settings_dir = __DIR__.'/../settings/';
	private $page_key_file = null;

	private $app_id = 0;
	private $app_secret = '';

	private $api_url = 'https://graph.facebook.com/v14.0/';

	private $settings = null;

	function __construct($app_id = null, $app_secret = null){
		$this->app_id = $app_id;
		$this->app_secret = $app_secret;
		$this->response_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__).'/response.php?app_id='.$app_id.'&app_secret='.$app_secret;

		$this->page_key_file = $this->settings_dir.'page_key.json';

		$this->settings = $this->get_settings();
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

	public function getBusinessId($page_id, $token){

		return json_decode(file_get_contents($this->api_url.$page_id.'?fields=instagram_business_account&access_token='.$token));
	}

	public function savePermanentToken($page_id, $user_token){
		$long_token = $this->getLongLivedToken($user_token);
		$permanent_token = $this->getPermanentToken($page_id, $long_token->access_token);
		$business = $this->getBusinessId($page_id, $permanent_token->access_token);

		if (!is_dir($this->settings_dir)) {
		  mkdir($this->settings_dir);
		}
		
		file_put_contents($this->page_key_file, json_encode(['instagram_business_id' => $business->instagram_business_account->id, 'access_token' => $permanent_token->access_token, 'page_id' => $page_id]));

		return true;
	}

	public function getFeed(){
		return $this->request('feed', [
			'fields' => 'full_picture,created_time,id,message,permalink_url',
			'limit' => 50
		]);
	}

	public function getInstagramFeed(){
		return $this->request_instagram('media', [
			'fields' => 'media_url,thumbnail_url,caption,comments_count,like_count,timestamp,permalink,media_type',
			'limit' => 50
		]);
	}

	private function get_settings(){
		if ($this->checkPageKey()) {
			return json_decode(file_get_contents($this->page_key_file));
		}

		return null;
	}

	private function request($endpoint, $data){
		return $this->do_request($this->api_url.$this->settings->page_id, $endpoint, $data);
	}

	private function request_instagram($endpoint, $data){
		return $this->do_request($this->api_url.$this->settings->instagram_business_id, $endpoint, $data);
	}

	private function do_request($url, $endpoint, $data = array()){
		$data['access_token'] = $this->settings->access_token;
		return json_decode(file_get_contents($url.'/'.$endpoint.'?'.http_build_query($data)));
	}

}
