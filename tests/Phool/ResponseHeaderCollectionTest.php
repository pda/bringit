<?php

class Phool_ResponseHeaderCollectionTest extends PhoolTestCase
{

	public function testEmptyCollection()
	{
		$collection = new Phool_Header_ResponseHeaderCollection(array());
		$this->assertEqual($collection->getHeaders(), array());
	}

	public function testBasicUsage()
	{
		$headers = array(
			new Phool_Header_SimpleHeader('test', 'one'),
			new Phool_Header_SimpleHeader('test', 'two')
		);

		$collection = new Phool_Header_ResponseHeaderCollection($headers);
		$this->assertEqual($collection->getHeaders(), $headers);

		$this->assertEqual("$collection", "Test: one\r\nTest: two\r\n");
	}

}
