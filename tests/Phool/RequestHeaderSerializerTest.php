<?php

class Phool_RequestHeaderSerializer extends UnitTestCase
{
	public function testBasicSerialization()
	{
		$header = new Phool_Header_RequestHeader();
		$header['content-type'] = 'text/plain';
		$header['content-length'] = 123;

		$serializer = new Phool_Header_RequestHeaderSerializer($header);
		$this->assertEqual(
			$serializer->serialize(),
			"Content-Type: text/plain\r\nContent-Length: 123\r\n\r\n"
		);
	}
}
