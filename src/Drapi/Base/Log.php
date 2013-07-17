<?php

namespace Drapi\Base;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log 
{
	/**
	 * Save all logger instances
	 * @var array
	 * @access protected
	 */
	protected $logger = array();

	/**
	 * Setup logger handler using Monolog\Logger
	 *
	 * @access public
	 * @uses Monolog\Logger logger handler
	 * @param  string $name log channel
	 * @param  \Monolog\Handler\HandlerInterface $handler log handler
	 * @return void
	 */
	public function setupLogger($name, \Monolog\Handler\HandlerInterface $handler) 
	{
		if (!array_key_exists($name, $this->logger)) {
			$this->logger[$name] = new Logger($name);			
		}

		//setup handler
		$this->logger[$name]->pushHandler($handler);
	}	

	/**
	 * Get logger instance
	 *
	 * @access public
	 * @param  string $name 	logger channel
	 * @return string|boolean
	 */
	public function getLogger($name) 
	{
		if (array_key_exists($name, $this->logger)) {
			return $this->logger[$name];
		}

		return false;
	}

	/**
	 * Check logger exists or not
	 * @param  string  $name 
	 * @return boolean       
	 */
	public function isLoggerExists($name) 
	{
		return array_key_exists($name, $this->logger);
	}
}