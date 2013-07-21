<?php

use Drapi\Response as DrapiResponse;
use Zend\Http\PhpEnvironment\Response;

class MockResponseObject extends DrapiResponse
{
	public function mockPhpResponse($object)
	{
		$this->response = $object;
	}
}

class ResponseTest extends PHPUnit_Framework_TestCase
{
	private $__PhpResponse;
	private $__Headers;
	private $__Response;

	public function setUp()	
	{
		$this->__PhpResponse = $this->getMockBuilder('Zend\Http\PhpEnvironment\Response')
									->disableOriginalConstructor()									
									->getMock();

		$this->__Headers = $this->getMockBuilder('Zend\Http\Headers')
								->disableOriginalConstructor()									
								->getMock();
	}

	public function testObject()
	{
		$this->mockingResponse();
		$this->assertTrue(is_a($this->__Response,'\Drapi\Response'));
	}

	public function testSend()
	{
		$this->__PhpResponse->expects($this->any())
							->method('setStatusCode')
							->will($this->returnSelf());

		$this->__PhpResponse->expects($this->any())
							->method('getHeaders')
							->will($this->returnValue($this->__Headers));

		$this->__PhpResponse->expects($this->any())
							->method('setContent')
							->will($this->returnCallback(function($arg) {
								return \Zend\Json\Json::encode($arg);
							}));

		$this->__PhpResponse->expects($this->any())
							->method('send')
							->will($this->returnCallback(function() {
								echo \Zend\Json\Json::encode(array('test' => 'testing'));								
							}));

		$this->__Headers->expects($this->any())
						->method('addHeaders')
						->will($this->returnCallback(function($arg) {
							return null;
						}));

		$this->mockingResponse();		

		$this->assertEquals($this->__PhpResponse,$this->__PhpResponse->setStatusCode(200));
		$this->assertEquals($this->__Headers,$this->__PhpResponse->getHeaders());
		$this->assertEquals(null,$this->__PhpResponse->getHeaders()->addHeaders(array('testing' => 'test')));
		$this->assertEquals(
			\Zend\Json\Json::encode(array('test' => 'testing')),
			$this->__PhpResponse->setContent(array('test' => 'testing')));	

		$this->expectOutputString(\Zend\Json\Json::encode(array('test' => 'testing')));
		$this->__Response->send(array('test' => 'testing'));	
	}

	private function mockingResponse()
	{
		$this->__Response = new MockResponseObject();
		$this->__Response->mockPhpResponse($this->__PhpResponse);
	}

}