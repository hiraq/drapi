<?php

use Drapi\Compiler as DrapiCompiler;
use Drapi\Request as DrapiRequest;
use Drapi\Router as DrapiRouter;
use Drapi\Response as DrapiResponse;
use Drapi\Handler as DrapiHandler;
use Drapi\Base\Abstracts\Handler as DrapiBaseHandler;

class MockCompilerObject extends DrapiCompiler
{
	public function mocking($router,$request,$response)
	{
		$this->router = $router;
		$this->request = $request;
		$this->response = $response;		
	}
}

class Test extends DrapiBaseHandler
{
	public function getDefaultOutput()
	{
		return array('test' => 'testing');
	}

	public function testing()
	{
		return array('key1' => 'value1');
	}
}

class PrefixTest extends DrapiBaseHandler
{
	public function getDefaultOutput()
	{
		return array('test' => 'testing');
	}

	public function testing()
	{
		return array('key1' => 'value1');
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
		$this->__Compiler = new MockCompilerObject(
			$this->__Router,$this->__Request,$this->__Response);
	}

	public function testObjects()
	{
		$this->assertTrue(is_a($this->__Request,'\Drapi\Request'));			
		$this->assertTrue(is_a($this->__Router,'\Drapi\Router'));
		$this->assertTrue(is_a($this->__Response,'\Drapi\Response'));		
		$this->assertTrue(is_a($this->__Compiler,'\Drapi\Compiler'));
	}	

	public function testGetRouter()
	{
		$this->assertEquals($this->__Router,$this->__Compiler->getRouter());
	}

	public function testGetRequest()
	{
		$this->assertEquals($this->__Request,$this->__Compiler->getRequest());
	}

	public function testGetResponse()
	{
		$this->assertEquals($this->__Response,$this->__Compiler->getResponse());
	}
	
	public function testCompile()
	{
		$request = $this->getMockRequest();
		$response = $this->getMockResponse();
		$handler = new DrapiHandler;

		$request->expects($this->once())
				->method('listen')
				->will($this->returnValue(null));

		$request->expects($this->once())
				->method('getUriPath')
				->will($this->returnValue('/test/testing'));

		$request->expects($this->once())
				->method('getParams')
				->will($this->returnValue(null));

		$response->expects($this->once())
				 ->method('send')
				 ->will($this->returnCallback(function() {
				 	echo \Zend\Json\Json::encode(array('key1' => 'value1'));
				 }));

		$this->mockingCompiler($this->__Router,$request,$response);

		$this->__Compiler->setHandler($handler);
		$this->__Compiler->compile();		

		$handlerName = $this->__Compiler->getHandlerName();
		$handlerAction = $this->__Compiler->getHandlerAction();

		$this->expectOutputString(\Zend\Json\Json::encode(array('key1' => 'value1')));
		$this->assertEquals('Test',$handlerName);
		$this->assertEquals('testing',$handlerAction);		
	}

	public function testCompileWithPrefix()
	{
		$request = $this->getMockRequest();
		$response = $this->getMockResponse();
		$handler = new DrapiHandler;

		$request->expects($this->once())
				->method('listen')
				->will($this->returnValue(null));

		$request->expects($this->once())
				->method('getUriPath')
				->will($this->returnValue('/test/testing'));

		$request->expects($this->once())
				->method('getParams')
				->will($this->returnValue(null));

		$response->expects($this->once())
				 ->method('send')
				 ->will($this->returnCallback(function() {
				 	echo \Zend\Json\Json::encode(array('key1' => 'value1'));
				 }));

		$this->mockingCompiler($this->__Router,$request,$response);

		$this->__Compiler->setHandler($handler);
		$this->__Compiler->setHandlerNameSpace('Prefix');
		$this->__Compiler->compile();		

		$handlerName = $this->__Compiler->getHandlerName();
		$handlerAction = $this->__Compiler->getHandlerAction();

		$this->expectOutputString(\Zend\Json\Json::encode(array('key1' => 'value1')));
		$this->assertEquals('Test',$handlerName);
		$this->assertEquals('testing',$handlerAction);		
	}

	private function mockingCompiler($router,$request,$response)
	{
		$this->__Compiler->mocking($router,$request,$response);
	}

	private function getMockRequest()
	{
		$request = $this->getMockBuilder('Drapi\\Request')
						->disableOriginalConstructor()
						->getMock();

		return $request;
	}

	private function getMockResponse()
	{
		$response = $this->getMockBuilder('Drapi\\Response')
						->disableOriginalConstructor()
						->getMock();

		return $response;
	}
}