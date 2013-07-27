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
	private $handlerNameSpace;
	private $handlerName;
	private $handlerAction;
	private $action;	

	/**
	 * Setup router,request and response objects
	 *
	 * @access public
	 * @param Router   $router
	 * @param Request  $request
	 * @param Response $response
	 */
	public function __construct(Router $router, Request $request, Response $response)
	{
		$this->router = $router;
		$this->request = $request;
		$this->response = $response;		
	}

	/**
	 * Compile process
	 *
	 * @access public
	 * @return void
	 */
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

		//run handler class
		$this->runHandler();
	}	

	/**
	 * Set main handler instance
	 *
	 * @access public
	 * @param Handler $handler
	 */
	public function setHandler($handler)
	{
		$this->handler = $handler;
	}

	/**
	 * Set handler namespace, default value is Drapi\Handler
	 *
	 * @access public
	 * @param string $namespace
	 */
	public function setHandlerNameSpace($namespace='Drapi\\Handler')
	{
		$this->handlerNameSpace = $namespace;
	}

	/**
	 * Get router manager
	 *
	 * @access public
	 * @return Router
	 */
	public function getRouter()
	{
		return $this->router;
	}

	/**
	 * Get request manager
	 *
	 * @access public
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * Get response manager
	 *
	 * @access public
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * Get handler name
	 * @return string
	 */
	public function getHandlerName()
	{
		return $this->handlerName;
	}

	/**
	 * Get handler action
	 *
	 * @access public
	 * @return string
	 */
	public function getHandlerAction()
	{
		return $this->handlerAction;
	}

	/**
	 * Run handler
	 *
	 * @access private
	 * @return void
	 */
	private function runHandler()
	{		
		if (!empty($this->handler)) {

			$this->handler->setRequest($this->request);
			$this->handler->setResponse($this->response);
			$this->handler->setHandlerName($this->handlerNameSpace.$this->handlerName);
			$this->handler->setHandlerAction($this->handlerAction);

			$output = $this->handler->getOutput();			
			$this->response->send($output);

		}
	}

	/**
	 * Check router for requested uri path
	 *
	 * @access private
	 * @return void
	 */
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

	/**
	 * Manual setup handler if not found in router
	 *
	 * @access private
	 * @return void
	 */
	private function manualSetupHandler()
	{
		if (strstr($this->uriPath,'/')) {
			
			$exp = explode('/',$this->uriPath);
			array_shift($exp);

			$this->handlerName = ucfirst(strtolower(current($exp)));

			if (count($exp) > 1) {
				$this->handlerAction = end($exp);
			}
			
		}
	}	
}