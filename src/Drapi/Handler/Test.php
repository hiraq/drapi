<?php

namespace Drapi\Handler;

use Drapi\Base\Abstracts\Handler as DrapiBaseHandler;

class Test extends DrapiBaseHandler
{
	public function getDefaultOutput()
	{
		return array(
			'test' => 'testing'
		);
	}

	public function get()
	{
		return array(
			'name' => 'test',
			'occupation' => 'web programmer'
		);
	}

	public function test_param()
	{
		return $this->request->getParams();
	}
}