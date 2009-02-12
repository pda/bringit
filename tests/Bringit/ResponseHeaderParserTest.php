<?php

class Bringit_ResponseHeaderParserTest extends BringitTestCase
{
	public function testParseFromString()
	{
		$parser = new Bringit_Header_ResponseHeaderParser();
		$header = $parser->parse(
			"HTTP/1.1 200 OK\r\ncontent-length: 1024\r\n"
		);

		$this->assertEqual($header->fields(), array(
			new Bringit_Header_HeaderField('Content-Length', '1024'),
		));

		$status = $header->statusLine();
		$this->assertEqual($status->httpVersion(), '1.1');
		$this->assertEqual($status->responseCode(), '200');
		$this->assertEqual($status->reasonPhrase(), 'OK');
		$this->assertEqual($status->__toString(), "HTTP/1.1 200 OK\r\n");
	}
}
