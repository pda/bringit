<?php

class Bringit_CookieTest extends UnitTestCase
{
	public function testBasicUsage()
	{
		$cookie = new Bringit_Cookie_Cookie(
			'name1',
			'value1',
			'www.example.org',
			'/'
		);

		$this->assertEqual($cookie->name(), 'name1');
		$this->assertEqual($cookie->value(), 'value1');
		$this->assertEqual($cookie->domain(), 'www.example.org');
		$this->assertEqual($cookie->path(), 'www.example.org');
	}
}
