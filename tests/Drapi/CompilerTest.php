<?php

use Drapi\Compiler as DrapiCompiler;
use Drapi\Request as DrapiRequest;
use Drapi\Router as DrapiRouter;
use Drapi\Response as DrapiResponse;
use Drapi\Handler as DrapiHandler;
use Zend\Http\PhpEnvironment\Request;
use Zend\Uri\Uri;
use Zend\Http\PhpEnvironment\Response;

class MockCompilerObject extends DrapiCompiler
{
	public function mocking($router,$request,$response,$handler)
	{
		$this->router = $router;
		$this->request = $request;
		$this->response = $response;
		$this->handler = $handler;
	}
}

class CompilerTest extends PHPUnit_Framework_TestCase
{
	private $__Router;
	private $__Request;
	private $__Response;
	private $__Compiler;
	private $__Handler;

	public function setUp()
	{
		$this->__Router = new DrapiRouter;
		$this->__Request = new DrapiRequest;
		$this->__Response = new DrapiResponse;
		$this->__Handler = new DrapiHandler;
		$this->__Compiler = new MockCompilerObject(
			$this->__Router,$this->__Request,$this->__Response,$this->__Handler);
	}

	public function testObjects()
	{
		$this->assertTrue(is_a($this->__Request,'\Drapi\Request'));			
		$this->assertTrue(is_a($this->__Router,'\Drapi\Router'));
		$this->assertTrue(is_a($this->__Response,'\Drapi\Response'));
		$this->assertTrue(is_a($this->__Handler,'\Drapi\Handler'));
		$this->assertTrue(is_a($this->__Compiler,'\Drapi\Compiler'));
	}
}