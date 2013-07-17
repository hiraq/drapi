<?php

namespace Drapi;

use Drapi\Base\Object as Object;
use Drapi\Request as Request;
use Drapi\Response as Response;
use Drapi\Router as Router;

class Compiler extends Object
{
	/**
	 * Router manager
	 *
	 * @access private
	 * @var Router
	 */
	private $router;

	/**
	 * Request manager
	 *
	 * @access private
	 * @var Request
	 */
	private $request;

	/**
	 * Response manager
	 * @var Response
	 */
	private $response;

	public function __construct(Router $router, Request $request, Response $response)
	{
		
	}

	public function compile()
	{

	}
}