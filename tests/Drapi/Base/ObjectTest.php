<?php

use Drapi\Base\Object as Object;

class ObjectTest extends PHPUnit_Framework_TestCase  
{
	private $__Object;

	public function setUp() 
	{
		$this->__Object = new Object();		
	}

	/**
	 * Test Object object and parent class
	 * 
	 * @covers Object::__construct	 
	 */
	public function testRequestObject() 
	{
		$this->assertTrue(is_a($this->__Object,'Drapi\Base\Object'));				
	}	

	/**
	 * Test object method > log
	 * 
	 * @covers Object::log
	 */
	public function testLog()
	{
		$this->assertTrue(method_exists($this->__Object, 'log'));
		$this->assertEquals(get_class($this->__Object->log()),'Drapi\Base\Log');
	}
}