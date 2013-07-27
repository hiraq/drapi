<?php

use Drapi\Handler as DrapiHandler;
use Drapi\Request as DrapiRequest;
use Drapi\Response as DrapiResponse;
use Drapi\Base\Abstracts\Handler as DrapiBaseHandler;

class FakeHandlerClass extends DrapiBaseHandler
{
	public function getDefaultOutput()
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
	private $__Handler;

	public function setUp()
	{
		$this->__Request = new DrapiRequest;
		$this->__Response = new DrapiResponse;
		$this->__Handler = new DrapiHandler;
	}

	public function testObjects()
	{
		$this->assertTrue(is_a($this->__Request,'Drapi\\Request'));
		$this->assertTrue(is_a($this->__Response,'Drapi\\Response'));
		$this->assertTrue(is_a($this->__Handler,'Drapi\\Handler'));
	}

	public function testGetDefaultOutput()
	{
		$this->__Handler->setRequest($this->__Request);
		$this->__Handler->setResponse($this->__Response);
		$this->__Handler->setHandlerName('FakeHandlerClass');

		$output = $this->__Handler->getOutput();
		$this->assertInternalType('array',$output);
		$this->assertArrayHasKey('test',$output);
		$this->assertEquals($output['test'],'testing');
	}	

	public function testGetActionOutput()
	{
		$this->__Handler->setRequest($this->__Request);
		$this->__Handler->setResponse($this->__Response);
		$this->__Handler->setHandlerName('FakeHandlerClass');
		$this->__Handler->setHandlerAction('test');

		$output = $this->__Handler->getOutput();
		$this->assertInternalType('array',$output);
		$this->assertArrayHasKey('key1',$output);
		$this->assertEquals($output['key1'],'value1');
	}

	public function testGetNotExistsActionOutput()
	{
		$this->__Handler->setRequest($this->__Request);
		$this->__Handler->setResponse($this->__Response);
		$this->__Handler->setHandlerName('FakeHandlerClass');
		$this->__Handler->setHandlerAction('testing');

		$output = $this->__Handler->getOutput();
		$this->assertInternalType('array',$output);
		$this->assertArrayHasKey('test',$output);
		$this->assertEquals($output['test'],'testing');
	}

	public function testGetOutputFalse()
	{
		$this->__Handler->setRequest($this->__Request);
		$this->__Handler->setResponse($this->__Response);
		$this->__Handler->setHandlerName('FakeHandlerClassNotExists');

		$output = $this->__Handler->getOutput();
		$this->assertFalse($output);
	}
}