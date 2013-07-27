<?php

namespace Drapi\Base\Abstracts;

use Drapi\Base\Object as Object;
use Drapi\Request as DrapiRequest;
use Drapi\Response as DrapiResponse;

abstract class Handler extends Object
{
	protected $request;
	protected $response;

	/**
	 * Setup request and response instance
	 *
	 * @access public
	 * @param DrapiRequest  $request
	 * @param DrapiResponse $response
	 */
	public function __construct(DrapiRequest $request, DrapiResponse $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	/**
	 * Get default output
	 *
	 * @access public
	 * @return array
	 */
	abstract public function getDefaultOutput();
}