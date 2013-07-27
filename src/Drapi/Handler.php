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

	public function setHandlerName($name)
	{
		$this->className = $name;
	}

	public function setHandlerAction($action)
	{
		$this->action = $action;
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

	public function setResponse($response)
	{
		$this->response = $response;
	}

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