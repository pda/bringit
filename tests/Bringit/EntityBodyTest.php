<?php

class Bringit_EntityBodyTest extends UnitTestCase
{
	public function testStringEntityBodyBasicUsage()
	{
		$factory = new Bringit_EntityBodyFactory();
		$body = $factory->createFromString('test content');

		$this->assertEqual($body->contentLength(), 12);
	}

	public function testSimpleEntityBodyBasicUsage()
	{
		$stream = fopen('php://memory', 'w');
		fwrite($stream, 'test stream data');
		rewind($stream);

		$factory = new Bringit_EntityBodyFactory();
		$body = $factory->createFromStream($stream);

		$this->assertEqual($body->contentLength(), 16);

		$this->assertFalse(feof($body->contentStream()), 'should not be EOF');
		$this->assertEqual(fread($body->contentStream(), 10), 'test strea');
		$this->assertEqual(fread($body->contentStream(), 10), 'm data');
		$this->assertTrue(feof($body->contentStream()), 'should be EOF');

		rewind($body->contentStream());
		$this->assertFalse(feof($body->contentStream()), 'should not be EOF');
		$this->assertEqual(fread($body->contentStream(), 1024), 'test stream data');
	}

	public function testSimpleEntityBodyMidStream()
	{
		$stream = fopen('php://memory', 'w');
		fwrite($stream, 'test stream data');
		fseek($stream, 9, SEEK_SET);

		$factory = new Bringit_EntityBodyFactory();
		$body = $factory->createFromStream($stream);

		$this->assertEqual($body->contentLength(), 7);

		$this->assertEqual(fread($body->contentStream(), 1024), 'am data');
	}
}
