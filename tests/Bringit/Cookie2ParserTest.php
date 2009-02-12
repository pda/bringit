<?php

class Bringit_Cookie2ParserTest extends UnitTestCase
{
	public function testBasicUsage()
	{
		$parser = new Bringit_Cookie_Cookie2Parser();
		$s = 'a="example cookie"; Path="/test"';
		$cookies = $parser->parse($uri, $s);

		$this->assertEqual(count($cookies), 1);
		$cookie = $cookies[0];

		$this->assertEqual($cookie->name(), 'a');
		$this->assertEqual($cookie->value(), 'example cookie');
		$this->assertEqual($cookie->path(), '/test');
	}

	public function testMultipleCookies()
	{
		$s = implode(', ', array(
			'a="example cookie"; Path="/test"',
			'b=meh; Domain=".example.org"',
			'c=test'
		));

		$parser = new Bringit_Cookie_Cookie2Parser();
		$cookies = $parser->parse($s);

		$this->assertEqual(count($cookies), 3);
	}
}
