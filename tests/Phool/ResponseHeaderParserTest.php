<?php

class Phool_ResponseHeaderParserTest extends PhoolTestCase
{

	public function testParseFromString()
	{
		$parser = new Phool_Header_ResponseHeaderParser();
		$header = $parser->parse(
			"HTTP/1.1 200 OK\r\ncontent-length: 1024\r\n"
		);

		$this->assertEqual($header->getHeaders(), array(
			new Phool_Header_HeaderField('Content-Length', '1024'),
		));

		$status = $header->getStatusLine();
		$this->assertEqual($status->getHttpVersion(), '1.1');
		$this->assertEqual($status->getResponseCode(), '200');
		$this->assertEqual($status->getReasonPhrase(), 'OK');
		$this->assertEqual($status->__toString(), "HTTP/1.1 200 OK\r\n");
	}

	public function testRoundTripWithInputObjectToString()
	{
		$requestHeader = new Phool_Header_RequestHeader();
		$requestHeader['content-length'] = 2048;
		$requestHeader['content-type'] = 'binary/blargzip';

		$parser = new Phool_Header_ResponseHeaderParser();
		$header = $parser->parse($requestHeader); // __toString

		$this->assertEqual($header->getHeaders(), array(
			new Phool_Header_HeaderField('Content-Length', '2048'),
			new Phool_Header_HeaderField('Content-Type', 'binary/blargzip')
		));
	}

}
