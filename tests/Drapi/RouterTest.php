<?php

use Drapi\Router as Router;

class RouterTest extends PHPUnit_Framework_TestCase 
{
	private $__Router;

	public function setUp()
	{
		$this->__Router = new Router();
	}

	public function testObject()
	{
		$this->assertTrue(is_a($this->__Router,'\Drapi\Router'));		
		$this->assertEquals('Drapi\Base\Object',get_parent_class($this->__Router));		
	}

	public function testRegisterPath()
	{
		$this->__Router->register('/test/path','test');
		$checkPath = $this->__Router->isPathRegistered('/test/path');

		$this->assertTrue($checkPath);
	}

	public function testGetPathHandler()
	{
		$this->__Router->register('/test/path','test');
		$path = $this->__Router->getPathHandler('/test/path');
		$fakePath = $this->__Router->getPathHandler('/test_fake/path');

		$this->assertEquals($path,'test');
		$this->assertFalse($fakePath);
	}
}