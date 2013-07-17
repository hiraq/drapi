<?php

namespace Drapi;

use Drapi\Base\Object as Object;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Uri\UriFactory as UriFactory;

class Request extends Object 
{		
	private $method;
	private $ip;	
	private $params = array();
	private $requestedHost;
	private $requestedPath;	
	private $requestedScheme = 'http://';
	private $requestedUrl;
	private $currentRequest = null;
	private $currentUri = null;
	private $authCallback = null;

	public function __construct()
	{
		$this->currentRequest = new PhpRequest();
	}

	public function listen()
	{

	}

	public function isRequestValid()
	{
		
	}

	public function setAuthCallback($callback)
	{

	}

	public function getMethod()
	{

	}

	public function getIp()
	{

	}

	public function getUri()
	{

	}

	public function getUriPath()
	{

	}

	public function getParams()
	{

	}

	private function buildUri()
	{

	}
}