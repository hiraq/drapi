<?php

use Drapi\Base\Log as Log;

class LogTest extends PHPUnit_Framework_TestCase
{
	private $__Log;

	public function setUp() 
	{
		$this->__Log = new Log();		
	}

	/**
	 * Test log object
	 * 
	 * @covers Log::__construct
	 */
	public function testLogObject()
	{
		$this->assertTrue(is_a($this->__Log,'Drapi\Base\Log'));				
	}
}