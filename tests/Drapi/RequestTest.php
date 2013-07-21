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

	/**
	 * Test get http request method	 
	 */
	public function testGetMethod()
	{		
		$this->__PhpRequest->expects($this->once())
							->method('getMethod')
							->will($this->returnValue('GET'));

		$this->mockingRequest();
		
		$method = $this->__Request->getMethod();
		$this->assertEquals('GET',$method);
	}

	/**
	 * Test get object uri & request	 
	 */
	public function testGetObject()
	{
		$this->mockingRequest();
		$uri = $this->__Request->getObjectUri();
		$request = $this->__Request->getObjectRequest();

		$this->assertEquals($uri,$this->__Uri);
		$this->assertEquals($request,$this->__PhpRequest);
	}

	/**
	 * Test listen current request	 
	 */
	public function testListen()
	{		
		/*
		setup stubbed php request
		 */
		$this->__PhpRequest->expects($this->any())
							->method('getServer')
							->will($this->returnCallback(function($arg) {
								switch($arg) {						   			
						   			case 'HTTP_HOST':
						   				return 'api.site.com';
						   			break;

						   			case 'REQUEST_URI':
						   				return '/test/users?name=testing&key1=value1';
						   			break;

						   			case 'HTTPS':
						   				return '';
						   			break;

						   			default:
						   				return false;
						   			break;
						   		}
							}));

		/*
		test stubbed uri object
		 */
		$this->__Uri->expects($this->any())
					->method('parse')
					->with($this->anything())
					->will($this->returnSelf());

		$this->__Uri->expects($this->any())
					->method('getPath')					
					->will($this->returnValue('/test/users'));

		$this->__Uri->expects($this->any())
					->method('getQueryAsArray')					
					->will($this->returnValue(array(
						'name' => 'testing',
						'key1' => 'value1'
					)));

		//create mocking objects
	   	$this->mockingRequest();

	   	/*
	   	test stubbed objects
	    */
	   	$this->assertEquals('api.site.com',$this->__PhpRequest->getServer('HTTP_HOST'));
	   	$this->assertEquals('',$this->__PhpRequest->getServer('HTTPS'));
	   	$this->assertEquals('/test/users?name=testing&key1=value1',$this->__PhpRequest->getServer('REQUEST_URI'));
	   	$this->assertEquals($this->__Uri,$this->__Uri->parse('test'));

	   	//test listen query
	   	$this->__Request->listen();
	   	$path = $this->__Request->getUriPath();
	   	$params = $this->__Request->getParams();

	   	$this->assertEquals('/test/users',$path);
	   	$this->assertInternalType('array',$params);
	   	$this->assertArrayHasKey('name',$params);
	   	$this->assertArrayHasKey('key1',$params);
	   	$this->assertEquals($params['name'],'testing');
	   	$this->assertEquals($params['key1'],'value1');
	}

	/**
	 * Test return false uri object	 
	 */
	public function testReturnFalseUri()
	{
		/*
		fake method
		 */
		$this->__Uri->expects($this->any())
					->method('getPath2')					
					->will($this->returnValue('/test/users?name=testing&key1=value1'));

		$this->mockingRequest();

		$path = $this->__Request->getUriPath();
		$params = $this->__Request->getParams();

		$this->assertFalse($path);
		$this->assertFalse($params);
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