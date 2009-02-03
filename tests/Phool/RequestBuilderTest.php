<?php

class Phool_RequestBuilderTest extends PhoolTestCase
{
	public function testBasicGetRequest()
	{
		$builder = new Phool_RequestBuilder();
		$request = $builder->url('http://example.org/')->create();

		$this->assertIsA($request, 'Phool_Request');
		$this->assertEqual($request->requestMethod(), Phool_Request::METHOD_GET);
		$this->assertEqual($request->url()->__toString(), 'http://example.org/');
		$this->assertFalse($request->hasEntityBody(), 'should not have entity body');

		$this->assertEqual($request->requestLine()->__toString(), "GET / HTTP/1.1\r\n");
		$this->assertIsA($request->header(), 'Phool_Header_RequestHeader');
		$this->assertEqual($request->header()->value('Host'), 'example.org');
	}

	public function testBuildWithoutUrlThrowsException()
	{
		$builder = new Phool_RequestBuilder();
		$this->expectException('Phool_Exception');
		$builder->create();
	}

	public function testRequestBuiltWithoutEntityBodyThrowsException()
	{
		$builder = new Phool_RequestBuilder();
		$request = $builder->url('http://example.org/')->create();

		$this->expectException('Phool_Exception');
		$request->entityBody();
	}

	public function testPutRequest()
	{
		$builder = new Phool_RequestBuilder();

		$url = new Phool_Url('http://example.org:81/blarg');
		$header = new Phool_Header_RequestHeader();
		$header['Content-Type'] = 'text/plain';

		$entityBodyFactory = new Phool_EntityBodyFactory();
		$entityBody = $entityBodyFactory->createFromString('testing');

		$builder
			->method(Phool_Request::METHOD_PUT)
			->url($url)
			->header($header)
			->body($entityBody);

		$request = $builder->create();

		$this->assertIsA($request, 'Phool_Request');

		$this->assertEqual($request->requestMethod(), Phool_Request::METHOD_PUT);
		$this->assertReference($request->url(), $url);
		$this->assertReference($request->header(), $header);
		$this->assertTrue($request->hasEntityBody(), 'should have entity body');
		$this->assertReference($request->entityBody(), $entityBody);
		$this->assertEqual($request->requestLine()->__toString(), "PUT /blarg HTTP/1.1\r\n");
		$this->assertEqual($header['Host'], 'example.org:81');
	}
}
