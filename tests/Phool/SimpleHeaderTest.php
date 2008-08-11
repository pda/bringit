<?php

class Phool_HeaderFieldTest extends PhoolTestCase
{

	public function testHeaderField()
	{
		$header = new Phool_Header_HeaderField('Host', 'example.org');
		$this->assertEqual($header->getName(), 'Host');
		$this->assertEqual($header->getValue(), 'example.org');
		$this->assertEqual("$header", "Host: example.org\r\n");
	}

	public function testHeaderFieldNameNormalization()
	{
		$header = new Phool_Header_HeaderField('Example-header', 'x');
		$this->assertEqual($header->getName(), 'Example-Header');
		$this->assertEqual("$header", "Example-Header: x\r\n");
	}

	public function testHeaderFieldFromString()
	{
		$header = Phool_Header_HeaderField::fromString('test: blarg: meh');
		$this->assertEqual($header->getName(), 'Test');
		$this->assertEqual($header->getValue(), 'blarg: meh');
	}

	public function testRoundTrip()
	{
		$string = "Test: blarg: meh\r\n";

		$this->assertEqual(
			Phool_Header_HeaderField::fromString($string)->__toString(),
			$string
		);
	}

}
