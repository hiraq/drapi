<?php

namespace Drapi;

use Drapi\Base\Object as Object;
use Zend\Http\PhpEnvironment\Response as PhpResponse;

class Response extends Object
{
	protected $response;

	public function __construct()
	{
		$this->response = new PhpResponse();
	}

	public function send($data,$code=202)
	{		
		$this->response->setStatusCode($code);
		$this->response->getHeaders()->addHeaders(array(
		    'Content-Type' => 'application/json'	    
		));

		if (is_array($data)) {
			$this->response->setContent(\Zend\Json\Json::encode($data));
		} else {
			$this->response->setContent(\Zend\Json\Json::encode(array(
				'error' => 1,
				'status' => 'failed data response')));
		}

		$this->response->send();
	}	
}