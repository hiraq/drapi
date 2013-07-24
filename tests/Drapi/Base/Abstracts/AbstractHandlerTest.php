<?php

use Drapi\Base\Abstracts\Handler as DrapiBaseHandler;
use Drapi\Request as DrapiRequest;
use Drapi\Response as DrapiResponse;

class FakeAbstractHandlerClass extends DrapiBaseHandler
{
	public function getOutput()
	{
		return array('test' => 'testing');
	}
}

class AbstractHandlerTest extends PHPUnit_Framework_TestCase
{
	private $__Request;
	private $__Response;
	private $__FakeHandler;

	public function setUp()
	{
		$this->__Request = new DrapiRequest;
		$this->__Response = new DrapiResponse;
		$this->__FakeHandler = new FakeHandlerClass($this->__Request,$this->__Response);
	}

	public function testObjects()
	{
		$this->assertTrue(is_a($this->__Request,'Drapi\\Request'));
		$this->assertTrue(is_a($this->__Response,'Drapi\\Response'));
		$this->assertTrue(is_a($this->__FakeHandler,'Drapi\\Base\\Abstracts\Handler'));
	}

	public function testOutputHandler()
	{
		$output = $this->__FakeHandler->getOutput();
		$this->assertInternalType('array',$output);
		$this->assertArrayHasKey('test',$output);
		$this->assertEquals($output['test'],'testing');
	}
}