<?php

use Drapi\Handler as DrapiHandler;
use Drapi\Request as DrapiRequest;
use Drapi\Response as DrapiResponse;
use Drapi\Base\Abstracts\Handler as DrapiBaseHandler;

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
	private $__Handler;

	public function setUp()
	{
		$this->__Request = new DrapiRequest;
		$this->__Response = new DrapiResponse;
		$this->__Handler = new DrapiHandler('FakeHandlerClass');
	}

	public function testObjects()
	{
		$this->assertTrue(is_a($this->__Request,'Drapi\\Request'));
		$this->assertTrue(is_a($this->__Response,'Drapi\\Response'));
		$this->assertTrue(is_a($this->__Handler,'Drapi\\Handler'));
	}

	public function testGetOutput()
	{
		$this->__Handler->setUpClassName('FakeHandlerClass');
		$handlerObj = $this->__Handler->get($this->__Request,$this->__Response);
		$this->assertTrue(!is_null($handlerObj));
		$this->assertTrue(is_a($handlerObj,'Drapi\\Base\\Abstracts\\Handler'));
	}

	public function testManualSetUpObj()
	{
		
		$this->__Handler->setUpClassName('FakeHandlerClass');
		$this->__Handler->setUpClassObj($this->__Request,$this->__Response,'FakeHandlerClass');

		$handlerObj = $this->__Handler->get($this->__Request,$this->__Response);
		$this->assertTrue(!is_null($handlerObj));
		$this->assertTrue(is_a($handlerObj,'Drapi\\Base\\Abstracts\\Handler'));
	}

	public function testActionHandler()
	{
		$this->__Handler = new DrapiHandler('FakeHandlerClass','test');
		$this->__Handler->setUpClassName('FakeHandlerClass');
		$this->__Handler->setUpClassObj($this->__Request,$this->__Response,'FakeHandlerClass');

		$handlerObj = $this->__Handler->get($this->__Request,$this->__Response);		
		$this->assertTrue(!is_null($handlerObj));
		$this->assertInternalType('array',$handlerObj);
		$this->assertArrayHasKey('key1',$handlerObj);
		$this->assertEquals($handlerObj['key1'],'value1');
	}

	public function testNullHandlerObj()
	{
		$handlerObj = $this->__Handler->get($this->__Request,$this->__Response);		
		$this->assertTrue(is_null($handlerObj));
	}
}