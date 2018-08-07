<?php

namespace Ntriga;

require_once __DIR__ . '/../vendor/autoload.php';

class Instagram
{
	private $response_url = '';
	private $page_id = '';

	function __construct($page_id){
		$this->response_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__).'/response.php';
		$this->page_id = $page_id;
	}

	public function showLogin(){
		$login_html = file_get_contents(__DIR__.'/facebook_login.html');
		echo str_replace('[[response_post_url]]', $this->response_url , $login_html);
	}

	public function getPosts(){

		echo 'syncing Instagram posts to database...';
		die();

		$settings = json_decode(file_get_contents(__DIR__.'/../settings/facebook_key.json'));

		$fb = new \Facebook\Facebook([
		  'app_id' => '213575729318742',
		  'app_secret' => 'a611ecce8716dd5e1d2d8cad2480a154',
		  'default_graph_version' => 'v3.1',
		  'default_access_token' => $settings->accessToken, // optional
		]);

		try {
		  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
		  // If you provided a 'default_access_token', the '{access-token}' is optional.
		  $response = $fb->get('/879710678749485?fields=business_discovery.username(bluebottle){followers_count,media_count,media}');
		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		var_dump($response);
		die();
	}


}
