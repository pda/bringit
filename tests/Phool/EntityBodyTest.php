<?php

class Phool_EntityBodyTest extends UnitTestCase
{

	public function testStringEntityBodyBasicUsage()
	{
		$factory = new Phool_EntityBodyFactory();
		$body = $factory->createFromString('test content', 'text/plain');

		$this->assertEqual($body->getContentType(), 'text/plain');
		$this->assertEqual($body->getContentLength(), 12);
		$this->assertFalse($body->hasContentEncoding(), 'body has no content encoding');
	}

	public function testSimpleEntityBodyBasicUsage()
	{
		$stream = fopen('php://memory', 'w');
		fwrite($stream, 'test stream data');
		rewind($stream);

		$factory = new Phool_EntityBodyFactory();
		$body = $factory->createFromStream($stream, 'text/plain');

		$this->assertEqual($body->getContentLength(), 16);
		$this->assertEqual($body->getContentType(), 'text/plain');

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

		$factory = new Phool_EntityBodyFactory();
		$body = $factory->createFromStream($stream, 'text/plain');

		$this->assertEqual($body->getContentLength(), 7);
		$this->assertEqual($body->getContentType(), 'text/plain');

		$this->assertEqual(fread($body->getContentStream(), 1024), 'am data');
	}

}