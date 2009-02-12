<?php

class Bringit_ResponseHeaderTest extends BringitTestCase
{
	public function testEmpty()
	{
		$header = new Bringit_Header_ResponseHeader(null, array());
		$this->assertEqual($header->fields(), array());
		$this->assertNull($header->statusLine());
	}

	public function testBasicUsage()
	{
		$headers = array(
			new Bringit_Header_HeaderField('test', 'one'),
			new Bringit_Header_HeaderField('test', 'two')
		);

		$header = new Bringit_Header_ResponseHeader(null, $headers);
		$this->assertEqual($header->fields(), $headers);
	}
}
