<?php

class Phool_SimpleHeaderTest extends PhoolTestCase
{

	public function testSimpleHeader()
	{
		$header = new Phool_Header_SimpleHeader('Host', 'example.org');
		$this->assertEqual($header->getName(), 'Host');
		$this->assertEqual($header->getValue(), 'example.org');
		$this->assertEqual("$header", "Host: example.org\r\n");
	}

	public function testSimpleHeaderNameNormalization()
	{
		$header = new Phool_Header_SimpleHeader('Example-header', 'x');
		$this->assertEqual($header->getName(), 'Example-Header');
		$this->assertEqual("$header", "Example-Header: x\r\n");
	}

}
