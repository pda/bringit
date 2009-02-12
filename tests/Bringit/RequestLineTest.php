<?php

class Bringit_RequestLineTest extends BringitTestCase
{
	public function testBasicUsage()
	{
		$string = "GET /test HTTP/1.1\r\n";

		$this->assertEqual(
			Bringit_Header_RequestLine::fromString($string)->__toString(),
			$string
		);
	}
}
