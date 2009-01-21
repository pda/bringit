<?php

class Phool_Body_EntityBodyTest extends UnitTestCase
{
	public function testStringEntityBodyBasicUsage()
	{
		$factory = new Phool_Body_EntityBodyFactory();
		$body = $factory->createFromString('test content');

		$this->assertEqual($body->getContentLength(), 12);
	}

	public function testSimpleEntityBodyBasicUsage()
	{
		$stream = fopen('php://memory', 'w');
		fwrite($stream, 'test stream data');
		rewind($stream);

		$factory = new Phool_Body_EntityBodyFactory();
		$body = $factory->createFromStream($stream);

		$this->assertEqual($body->getContentLength(), 16);

		$this->assertFalse(feof($body->getContentStream()), 'should not be EOF');
		$this->assertEqual(fread($body->getContentStream(), 10), 'test strea');
		$this->assertEqual(fread($body->getContentStream(), 10), 'm data');
		$this->assertTrue(feof($body->getContentStream()), 'should be EOF');

		rewind($body->getContentStream());
		$this->assertFalse(feof($body->getContentStream()), 'should not be EOF');
		$this->assertEqual(fread($body->getContentStream(), 1024), 'test stream data');
	}

	public function testSimpleEntityBodyMidStream()
	{
		$stream = fopen('php://memory', 'w');
		fwrite($stream, 'test stream data');
		fseek($stream, 9, SEEK_SET);

		$factory = new Phool_Body_EntityBodyFactory();
		$body = $factory->createFromStream($stream);

		$this->assertEqual($body->getContentLength(), 7);

		$this->assertEqual(fread($body->getContentStream(), 1024), 'am data');
	}
}