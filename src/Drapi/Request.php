<?php

namespace Drapi;

use Drapi\Base\Object as Object;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Uri\Uri as Uri;

class Request extends Object
{		
	private $method;
	private $ip;	
	private $params = array();
	private $requestedHost;
	private $requestedPath;	
	private $requestedScheme = 'http://';
	private $requestedUrl;
	protected $currentRequest = null;
	protected $currentUri = null;
	protected $authCallback = null;

	public function __construct()
	{
		$this->currentRequest = new PhpRequest();
		$this->currentUri = new Uri();
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
		return $this->currentRequest->getMethod();
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