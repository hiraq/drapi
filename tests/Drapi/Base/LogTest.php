<?php

use Drapi\Base\Log as Log;

class LogTest extends PHPUnit_Framework_TestCase
{
	private $__Log;
	private $__LogMock;

	public function setUp() 
	{
		$this->__Log = new Log();		
	}

	/**
	 * Test log object	 	
	 */
	public function testLogObject()
	{
		$this->assertTrue(is_a($this->__Log,'Drapi\Base\Log'));	
		$this->assertTrue(method_exists($this->__Log, 'setupLogger'));
		$this->assertTrue(method_exists($this->__Log, 'getLogger'));
		$this->assertTrue(method_exists($this->__Log, 'isLoggerExists'));
	}
	
	/**
	 * Test setup logger > channel name
	 * 
	 * @covers Drapi\Base\Log::setupLogger
	 */
	public function testSetUpLoggerName()
	{	
		$this->__Log->setupLogger('log_name',new \Monolog\Handler\TestHandler());
		$logger = $this->__Log->getLogger('log_name');

		$this->assertInternalType('object',$logger);
	}

	/**
	 * Test get logger object
	 * 
	 * @covers Drapi\Base\Log::getLogger
	 */
	public function testGetLogger()
	{		
		$this->__Log->setupLogger('testing',new \Monolog\Handler\TestHandler());
		$logger = $this->__Log->getLogger('testing');
		$loggerTest = new \Monolog\Logger('testing');
		$loggerTest->pushHandler(new \Monolog\Handler\TestHandler());

		$this->assertEquals($loggerTest,$logger);
	}

	/**
	 * Test if given channel not registered
	 * 
	 * @covers Drapi\Base\Log::getLogger
	 */
	public function testGetLoggerFailed()
	{	
		$logger = $this->__Log->getLogger('testing');
		$this->assertFalse($logger);
	}

	/**
	 * Test check if logger exists or not
	 * 
	 * @covers Drapi\Base\Log::isLoggerExists
	 */
	public function testLoggerExists()
	{		
		$this->__Log->setupLogger('test1',new \Monolog\Handler\TestHandler());
		$this->assertTrue($this->__Log->isLoggerExists('test1'));
		$this->assertFalse($this->__Log->isLoggerExists('test3'));
	}
}