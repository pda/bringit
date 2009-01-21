<?php

class Phool_ResponseStatusLineTest extends PhoolTestCase
{
	public function testBasicUsage()
	{
		$string = "HTTP/1.1 404 Not Found\r\n";

		$this->assertEqual(
			Phool_Header_ResponseStatusLine::fromString($string)->__toString(),
			$string
		);
	}
}
