<?php

namespace Drapi;

use Drapi\Base\Object as Object;
use Drapi\Base\Abstracts\Handler as DrapiBaseHandler;
use Drapi\Request as DrapiRequest;
use Drapi\Response as DrapiResponse;

class Handler extends Object
{
	protected $name;
	protected $action;
	protected $request;
	protected $response;

	private $className;
	private $classObj;		

	/**
	 * Set handler name
	 *
	 * @access public
	 * @param string $name
	 */
	public function setHandlerName($name)
	{
		$this->className = $name;
	}

	/**
	 * Set handler action if any
	 * @param string $action
	 */
	public function setHandlerAction($action)
	{
		$this->action = $action;
	}	

	/**
	 * Set request instance
	 *
	 * @access public
	 * @param Drapi\Request $request
	 */
	public function setRequest($request)
	{
		$this->request = $request;
	}

	/**
	 * Set response instance
	 *
	 * @access public
	 * @param Drapi\Response $response
	 */
	public function setResponse($response)
	{
		$this->response = $response;
	}

	/**
	 * Get output from handler
	 *
	 * @access public
	 * @return array|boolean
	 */
	public function getOutput()
	{		
		$handlerObj = null;
		if (class_exists($this->className)) {
			$handlerObj = new $this->className($this->request,$this->response);
		}
		
		if (!is_null($handlerObj)) {

			if (!empty($this->action) && method_exists($handlerObj,$this->action)) {
				return $handlerObj->{$this->action}();
			} else {
				return $handlerObj->getDefaultOutput();
			}

		}

		return false;
			
	}
}