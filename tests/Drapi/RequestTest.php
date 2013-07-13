<?php

use Drapi\Request as Request;

class RequestTest extends PHPUnit_Framework_TestCase 
{

	private $__Request;

	public function setUp() 
	{
		$this->__Request = new Request();		
	}

	/**
	 * Test Request object and parent class
	 * 
	 * @covers Request::__construct
	 * @convers Request::log
	 * @convers Object::log
	 */
	public function testRequestObject() 
	{
		$this->assertTrue(is_a($this->__Request,'\Drapi\Request'));		
		$this->assertEquals('Drapi\Base\Object',get_parent_class($this->__Request));		
	}

}