<?php

namespace Ntriga;

class Instagram
{
	function __construct(){

	}

	public function showLogin(){
		echo file_get_contents(__DIR__.'/facebook_login.html');
	}


}
