<?php

namespace Drapi;

use Drapi\Base\Object as Object;
use Zend\Http\PhpEnvironment\Request as PhpRequest;
use Zend\Uri\Uri as Uri;

class Request extends Object
{		
	private $method;	
	private $params = array();
	private $requestedHost;
	private $requestedPath;	
	private $requestedScheme = 'http://';
	private $requestedUri;	
	private $isHttpsOn = false;
	protected $currentRequest = null;
	protected $currentUri = null;	

	/**
	 * Construct
	 */
	public function __construct()
	{
		$this->currentRequest = new PhpRequest();	
		$this->currentUri = new Uri();	
	}

	/**
	 * Listen to current http request
	 *
	 * @access public
	 * @return void
	 */
	public function listen()
	{

		/*
		setup host & path
		 */
		$this->requestedHost = $this->currentRequest->getServer('HTTP_HOST');
		$this->requestedPath = $this->currentRequest->getServer('REQUEST_URI');

		/*
		setup https/http scheme
		 */
		$https = $this->currentRequest->getServer('HTTPS');
		$this->isHttpsOn = !empty($https) && $https == 'on' ? true : false;
		$this->requestedScheme = !$this->isHttpsOn ? 'http://' : 'https://';

		//build uri to managed with Zend\Uri
		$this->buildUri();
	}	

	/**
	 * Get http method (GET,POST,PUT,DELETE)
	 *
	 * @access public
	 * @return string
	 */
	public function getMethod()
	{				
		return $this->currentRequest->getMethod();
	}	

	/**
	 * Get Uri object
	 *
	 * @access public
	 * @return Uri
	 */
	public function getObjectUri()
	{
		return $this->currentUri;
	}

	/**
	 * Get PhpRequest object
	 *
	 * @access public
	 * @return PhpRequest
	 */
	public function getObjectRequest()
	{
		return $this->currentRequest;
	}

	/**
	 * Get current uri path
	 *
	 * @access public
	 * @return boolean|string
	 */
	public function getUriPath()
	{
		if (method_exists($this->requestedUri,'getPath')) {
			return $this->requestedUri->getPath();
		}

		return false;
	}

	/**
	 * Get current request query parameters
	 *
	 * @access public
	 * @return boolean|string
	 */
	public function getParams()
	{
		if (method_exists($this->requestedUri,'getQueryAsArray')) {
			return $this->requestedUri->getQueryAsArray();
		}

		return false;
	}	

	/**
	 * Build uri string
	 *
	 * @access private
	 * @return void
	 */
	private function buildUri()
	{		
		$url = $this->requestedScheme.$this->requestedHost.$this->requestedPath;			
		$this->requestedUri = $this->currentUri->parse($url);
	}
}