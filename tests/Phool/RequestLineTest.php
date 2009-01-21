<?php

class Phool_RequestLineTest extends PhoolTestCase
{
	public function testBasicUsage()
	{
		$string = "GET /test HTTP/1.1\r\n";

		$this->assertEqual(
			Phool_Header_RequestLine::fromString($string)->__toString(),
			$string
		);
	}
}
