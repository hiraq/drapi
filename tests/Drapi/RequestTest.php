<?php

use Drapi\Request as DrapiRequest;
use Zend\Http\PhpEnvironment\Request;
use Zend\Uri\Uri;

class MockRequestObject extends DrapiRequest
{
	public function mockPhpRequest($object)
	{				
		$this->currentRequest = $object;
	}

	public function mockUriObject($object)
	{
		$this->currentUri = $object;
	}
}

class RequestTest extends PHPUnit_Framework_TestCase 
{

	private $__Request;
	private $__PhpRequest;
	private $__Uri;
	private $__uriString;

	public function setUp() 
	{
		$this->__PhpRequest = $this->getMockBuilder('Zend\Http\PhpEnvironment\Request')
									->disableOriginalConstructor()									
									->getMock();		

		$this->__Uri = $this->getMockBuilder('Zend\Uri\Uri')
							->disableOriginalConstructor()							
							->getMock();

		$this->__uriString = 'http://api.site.com/test/users?name=testing&key1=value1';
	}

	/**
	 * Test Request object and parent class	 	
	 */
	public function testRequestObject() 
	{
		$this->mockingRequest();
		$this->assertTrue(is_a($this->__Request,'\Drapi\Request'));				
	}

	public function testGetMethod()
	{		
		$this->__PhpRequest->expects($this->once())
							->method('getMethod')
							->will($this->returnValue('GET'));

		$this->mockingRequest();

		$this->assertTrue(method_exists($this->__Request, 'getMethod'));
		$method = $this->__Request->getMethod();
		$this->assertEquals('GET',$method);
	}

	/**
	 * Regenerate Request object using mocking PhpRequest & Uri	 
	 */
	private function mockingRequest()
	{
		$this->__Request = new MockRequestObject();
		$this->__Request->mockPhpRequest($this->__PhpRequest);
		$this->__Request->mockUriObject($this->__Uri);
	}

}