<?php

namespace Drapi;

use Drapi\Base\Object as Object;

class Router extends Object
{
	/**
	 * Save registered uris and their handler
	 *
	 * @access private
	 * @var array
	 */
	private $urisHandler = array();

	/**
	 * Register path url
	 *
	 * @access public
	 * @param  string $path   
	 * @param  string $handler
	 * @return void
	 */
	public function register($path,$handler)
	{
		$check = $this->isPathRegistered($path);
		if (!$check) {
			$this->urisHandler[$path] = $handler;
		}
	}

	/**
	 * Check if path registered or not
	 *
	 * @access public
	 * @param  string  $path
	 * @return boolean      
	 */
	public function isPathRegistered($path)
	{
		return array_key_exists($path,$this->urisHandler);
	}

	/**
	 * Get handler for registered path
	 * 
	 * @param  string $path 
	 * @return boolean|string
	 */
	public function getPathHandler($path)
	{
		$check = $this->isPathRegistered($path);
		if ($check) {
			return $this->urisHandler[$path];
		}

		return false;
	}	
}