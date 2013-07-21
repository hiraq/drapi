<?php

namespace Drapi;

use Drapi\Base\Object as Object;
use Drapi\Request as Request;
use Drapi\Response as Response;
use Drapi\Router as Router;

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

	private $uriPath;	
	private $uriParams;
	private $handler;
	private $action;

	/**
	 * Setup router,request and response objects
	 * 
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

	public function getHandler()
	{
		return $this->handler;
	}

	private function checkRouter()
	{
		/*
		check path handler from router
		 */
		if (!empty($this->uriPath)) {
			$this->handler = ucfirst(strtolower($this->router->getPathHandler($this->uriPath)));
		}

		/*
		if handler not defined, then manually search for handler based on path
		 */
		if (!$this->handler) {
			$this->manualSetupHandler();
		}
	}

	private function manualSetupHandler()
	{
		if (strstr($this->uriPath,'/')) {
			$exp = explode('/',$this->uriPath);
			$this->handler = ucfirst(strtolower(current($exp)));
			$this->action = ucfirst(strtolower(end($exp)));
		}
	}

	private function loadHandler()
	{
		if (!empty($this->handler)) {

			//setup handler class name
			$classname = 'Drapi\\Handler\\'.$this->handler;

			/*
			if handler exists then load it based on action
			or only to get output
			 */
			if (class_exists($classname)) {

				$handler = new $classname($this->uriPath,$this->uriParams);	
				if (!empty($this->action)) {

					$action = $this->action;
					if (method_exists($handler,$action)) {
						$output = $handler->$action();	
						$code = 202;	
					} else {
						$output = array('status' => 'error','message' => 'Unknown action handler');
						$code = 404;
					}
					

				} else {

					if (method_exists($handler,'getOutput')) {
						$output = $handler->getOutput();
						$code = 202;
					} else {
						$output = array('status' => 'error','message' => 'Failed data response');
						$code = 400;
					}
				}

				$this->response->send($output,$code);
			} else {
				//if handler class not exists
				$this->response->send(array('status' => 'error','message' => 'Bad request'),400);
			}
		} else {
			//unknown path and handler
			$this->response->send(array('status' => 'error','message' => 'Unknown request'),404);
		}
	}
}