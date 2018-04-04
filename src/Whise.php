<?php

namespace Ntriga;

class Whise
{
	private $client_id;
	private $endpoint = 'http://webservices.whoman2.be/websiteservices/EstateService.svc';
	private $format = 'json';
	private $call = '';

	function __construct($client_id, $optional = array()){
		$this->client_id = $client_id;

		if (isset($optional['endpoint'])) {
			$this->endpoint = $optional['endpoint'];
		}
	}

	private function make_api_call($action, $request, $options = array()){

		$options['ClientId'] =  $this->client_id;

		$params = [
			$request => json_encode($options)
		];

		$this->call = "$this->endpoint/$action?".http_build_query($params);

		$result = file_get_contents($this->call);

		return $result;
	}

	public function getLastCall(){
		return $this->call;
	}

	public function getEstateList($options){

		$result = $this->make_api_call('GetEstateList', 'EstateServiceGetEstateListRequest', $options);
		$result = json_decode($result);

		if ($result != false) {
			$result = $result->d->EstateList;
		}

		return $result;
	}
}
