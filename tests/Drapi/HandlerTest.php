<?php

use Drapi\Handler as DrapiHandler;
use Drapi\Request as DrapiRequest;
use Drapi\Response as DrapiResponse;
use Drapi\Base\Abstracts\Handler as DrapiBaseHandler;

class FakeMainHandlerClass extends DrapiHandler
{
	/**
	 * Override parent 'get' method
	 * @param  DrapiRequest  $request
	 * @param  DrapiResponse $response
	 * @return null|object                 
	 */
	public function get(DrapiRequest $request, DrapiResponse $response)
	{
		$className = ucfirst(strtolower($this->name));
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

class FakeHandlerClass extends DrapiBaseHandler
{
	public function getOutput()
	{
		return array('test' => 'testing');
	}

	public function test()
	{
		return array('key1' => 'value1');
	}
}

class HandlerTest extends PHPUnit_Framework_TestCase
{
	private $__Request;
	private $__Response;
	private $__FakeMainHandler;

	public function setUp()
	{
		$this->__Request = new DrapiRequest;
		$this->__Response = new DrapiResponse;
		$this->__FakeMainHandler = new FakeMainHandlerClass('FakeHandlerClass');
	}

	public function testObjects()
	{
		$this->assertTrue(is_a($this->__Request,'Drapi\\Request'));
		$this->assertTrue(is_a($this->__Response,'Drapi\\Response'));
		$this->assertTrue(is_a($this->__FakeMainHandler,'Drapi\\Handler'));
	}

	public function testGetOutput()
	{
		$handlerObj = $this->__FakeMainHandler->get($this->__Request,$this->__Response);
		$this->assertTrue(!is_null($handlerObj));
		$this->assertTrue(is_a($handlerObj,'Drapi\\Base\\Abstracts\\Handler'));
	}
}