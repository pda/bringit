<?php

class Bringit_HeaderFieldTest extends BringitTestCase
{
	public function testHeaderField()
	{
		$header = new Bringit_Header_HeaderField('Host', 'example.org');
		$this->assertEqual($header->name(), 'Host');
		$this->assertEqual($header->value(), 'example.org');
		$this->assertEqual("$header", "Host: example.org\r\n");
	}

	public function testHeaderFieldNameNormalization()
	{
		$header = new Bringit_Header_HeaderField('Example-header', 'x');
		$this->assertEqual($header->name(), 'Example-Header');
		$this->assertEqual("$header", "Example-Header: x\r\n");
	}

	public function testHeaderFieldFromString()
	{
		$header = Bringit_Header_HeaderField::fromString('test: blarg: meh');
		$this->assertEqual($header->name(), 'Test');
		$this->assertEqual($header->value(), 'blarg: meh');
	}

	public function testRoundTrip()
	{
		$string = "Test: blarg: meh\r\n";

		$this->assertEqual(
			Bringit_Header_HeaderField::fromString($string)->__toString(),
			$string
		);
	}
}
