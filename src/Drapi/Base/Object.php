<?php

namespace Drapi\Base;

use Drapi\Base\Log as Log;

/**
 * Main object handler
 *
 * Contains Log that wrap Monolog\Logger to manage log operations
 *
 * @author Hiraq <hrxwan@gmail.com>
 */
class Object
{
	private $log;

	/**
	 * Create Drapi\Base\Log object
	 */
	public function __construct() 
	{
		$this->log = new Log;
	}

	/**
	 * Get log object
	 * @return Drapi\Base\Log
	 */
	public function log()
	{
		return $this->log;
	}	
}