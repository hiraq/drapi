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
	private $className;
	private $classObj;	

	public  function __construct($name,$action=null)
	{
		$this->name = ucfirst(strtolower($name));
		$this->action = $action;
	}

	public function setUpClassName($name=null)
	{
		$this->className = is_null($name) ? 'Drapi\\Handler\\'.$this->name : $name;
	}

	public function setUpClassObj($request,$response,$name=null)
	{
		if (is_null($name)) {
			if (class_exists($this->className)) {
				$this->classObj = new $this->className($request,$response);
			}
		} else {
			if (class_exists($name)) {
				$this->classObj = new $name($request,$response);
			}
		}		
	}

	public function get(DrapiRequest $request, DrapiResponse $response)
	{		
		//setup class name
		if (empty($this->className)) {
			$this->setUpClassName('Drapi\\Handler\\'.ucfirst(strtolower($this->name)));
		}

		//setup class obj
		if (empty($this->classObj)) {			
			$this->setUpClassObj($request,$response);	
		}		

		/*
		check for action handler
		 */
		if (!empty($this->action) && !empty($this->classObj)) {
			return $this->classObj->{$this->action}();
		} else {
			return $this->classObj;
		}
	}
}