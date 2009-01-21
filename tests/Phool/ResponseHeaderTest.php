<?php

class Phool_ResponseHeaderTest extends PhoolTestCase
{
	public function testEmpty()
	{
		$header = new Phool_Header_ResponseHeader(null, array());
		$this->assertEqual($header->getHeaders(), array());
		$this->assertNull($header->getStatusLine());
	}

	public function testBasicUsage()
	{
		$headers = array(
			new Phool_Header_HeaderField('test', 'one'),
			new Phool_Header_HeaderField('test', 'two')
		);

		$header = new Phool_Header_ResponseHeader(null, $headers);
		$this->assertEqual($header->getHeaders(), $headers);
	}
}
