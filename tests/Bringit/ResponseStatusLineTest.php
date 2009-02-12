<?php

class Bringit_ResponseStatusLineTest extends BringitTestCase
{
	public function testBasicUsage()
	{
		$string = "HTTP/1.1 404 Not Found\r\n";

		$this->assertEqual(
			Bringit_Header_ResponseStatusLine::fromString($string)->__toString(),
			$string
		);
	}
}
