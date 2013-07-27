drapi 
=====

A framework to create and manage API (REST) services

[![Build Status](https://travis-ci.org/hiraq/drapi.png?branch=dev)](https://travis-ci.org/hiraq/drapi)
[![Coverage Status](https://coveralls.io/repos/hiraq/drapi/badge.png)](https://coveralls.io/r/hiraq/drapi)
[![Latest Stable Version](https://poser.pugx.org/hiraq/drapi/v/stable.png)](https://packagist.org/packages/hiraq/drapi)
[![Total Downloads](https://poser.pugx.org/hiraq/drapi/downloads.png)](https://packagist.org/packages/hiraq/drapi)

usage
=====

Put this codes in your `index.php` file.

	<?php
	require_once 'vendor/autoload.php';

	use Drapi\Router;
	use Drapi\Request as DrapiRequest;
	use Drapi\Response as DrapiResponse;
	use Drapi\Handler;
	use Drapi\Compiler;

	try {

		$router = new Router;
		$request = new DrapiRequest;
		$response = new DrapiResponse;
		$handler = new Handler;

		$compiler = new Compiler($router,$request,$response);
		$compiler->setHandlerNameSpace('Drapi\\Handler\\');
		$compiler->setHandler($handler);
		$compiler->compile();

	} catch (Exception $e) {
		echo $e->getMessage();
	}

Then try to open your browser, and go to 

1. `http://localhost/myapi/test` or `http://localhost/myapi/test/get`
2. `http://localhost/myapi/testing` for failed data response example
3. `http://php.drapi/test/test_param?key1=val1&key2=val2` for GET parameters example

Drapi doesn't need any rewrite rules!

handler
======

A handler is class to manage and return a data from your datasource (MySQL,Postgre,Mongodb,etc).  
Create a handler class inside Drapi/Handler, such as `Users.php`.  Everytime your server get a 
API request based on: '/users/get', then your handler (Users.php) will be loaded and will use method `get`
inside Users class.  See Test.php inside Drapi/Handler for example.

plugin
======

A plugin is an extension for your handler class, create a class such as Mongo.php in Drapi/Handler/Plugin
and load this class inside your handler class (autoload).

response
========

All Drapi response is a data formatted in json.  If any request that fail to call a handler or maybe
there are no valid data available, then Drapi will automatically give an error status and message.

license
=======

Drapi is released under the [BSD 3-Clause](http://opensource.org/licenses/BSD-3-Clause) License.
See LICENSE.txt file for details.