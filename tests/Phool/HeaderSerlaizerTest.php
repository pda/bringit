<?php

class PhoolTest extends UnitTestCase
{

	public function testBasicSerialization()
	{
		$collection = new Phool_Header_RequestHeaderCollection();
		$collection['content-type'] = 'text/plain';
		$collection['content-length'] = 123;

		$serializer = new Phool_Header_HeaderSerializer($collection);
		$this->assertEqual(
			$serializer->serialize(),
			"Content-Type: text/plain\r\nContent-Length: 123\r\n"
		);
	}

}
