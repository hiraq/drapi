<?php

namespace Drapi;

use Drapi\Base\Object as Object;
use Drapi\Request as Request;
use Drapi\Response as Response;
use Drapi\Router as Router;
use Drapi\Handler as Handler;

class Compiler extends Object
{
	/**
	 * Router manager
	 *
	 * @access private
	 * @var Router
	 */
	protected $router;

	/**
	 * Request manager
	 *
	 * @access private
	 * @var Request
	 */
	protected $request;

	/**
	 * Response manager
	 * @var Response
	 */
	protected $response;

	/**
	 * Handler manager
	 * @var Handler
	 */
	protected $handler;

	private $uriPath;	
	private $uriParams;	
	private $handlerName;
	private $handlerAction;
	private $action;	

	/**
	 * Setup router,request and response objects
	 * 
	 * @param Router   $router
	 * @param Request  $request
	 * @param Response $response
	 */
	public function __construct(Router $router, Request $request, Response $response,Handler $handler)
	{
		$this->router = $router;
		$this->request = $request;
		$this->response = $response;
		$this->handler = $handler;
	}

	public function compile()
	{
		//listen to current request
		$this->request->listen();

		/*
		setup uri properties
		 */
		$this->uriPath = $this->request->getUriPath();
		$this->uriParams = $this->request->getParams();

		//check path to router
		$this->checkRouter();
	}

	/**
	 * Get handler manager
	 * @return Handler
	 */
	public function getHandler()
	{
		return $this->handler;
	}

	/**
	 * Get router manager
	 * @return Router
	 */
	public function getRouter()
	{
		return $this->router;
	}

	/**
	 * Get request manager
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * Get response manager
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}

	private function checkRouter()
	{
		/*
		check path handler from router
		 */
		if (!empty($this->uriPath)) {
			$this->handlerName = ucfirst(strtolower($this->router->getPathHandler($this->uriPath)));
		}

		/*
		if handler not defined, then manually search for handler based on path
		 */
		if (!$this->handlerName) {
			$this->manualSetupHandler();
		}
	}

	private function manualSetupHandler()
	{
		if (strstr($this->uriPath,'/')) {
			$exp = explode('/',$this->uriPath);
			$this->handlerName = ucfirst(strtolower(current($exp)));
			$this->handlerAction = ucfirst(strtolower(end($exp)));
		}
	}	
}