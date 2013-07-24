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

	public  function __construct($name,$action=null)
	{
		$this->name = $name;
		$this->action = $action;
	}

	public function get(DrapiRequest $request, DrapiResponse $response)
	{
		$className = 'Drapi\\Handler\\'.ucfirst(strtolower($this->name));
		$classObj = null;

		if (class_exists($className)) {
			$classObj = new $className($request,$response);
		}

		if (!is_null($classObj) 
			&& is_a($classObj,'Drapi\\Base\\Abstracts\\Handler')) {

			if (!empty($this->action)) {
				return $classObj->$action();
			}

		}

		return $classObj;
	}
}