<?php

class Bringit_RequestBuilderTest extends BringitTestCase
{
	public function testBasicGetRequest()
	{
		$builder = new Bringit_RequestBuilder();
		$request = $builder->url('http://example.org/')->create();

		$this->assertIsA($request, 'Bringit_Request');
		$this->assertEqual($request->requestMethod(), Bringit_Request::METHOD_GET);
		$this->assertEqual($request->url()->__toString(), 'http://example.org/');
		$this->assertFalse($request->hasEntityBody(), 'should not have entity body');

		$this->assertEqual($request->requestLine()->__toString(), "GET / HTTP/1.1\r\n");
		$this->assertIsA($request->header(), 'Bringit_Header_RequestHeader');
		$this->assertEqual($request->header()->value('Host'), 'example.org');
	}

	public function testBuildWithoutUrlThrowsException()
	{
		$builder = new Bringit_RequestBuilder();
		$this->expectException('Bringit_Exception');
		$builder->create();
	}

	public function testRequestBuiltWithoutEntityBodyThrowsException()
	{
		$builder = new Bringit_RequestBuilder();
		$request = $builder->url('http://example.org/')->create();

		$this->expectException('Bringit_Exception');
		$request->entityBody();
	}

	public function testPutRequest()
	{
		$builder = new Bringit_RequestBuilder();

		$url = new Bringit_Url('http://example.org:81/blarg');
		$header = new Bringit_Header_RequestHeader();
		$header['Content-Type'] = 'text/plain';

		$entityBodyFactory = new Bringit_EntityBodyFactory();
		$entityBody = $entityBodyFactory->createFromString('testing');

		$request = $builder
			->method(Bringit_Request::METHOD_PUT)
			->url($url)
			->header($header)
			->body($entityBody)
			->create();

		$this->assertIsA($request, 'Bringit_Request');

		$this->assertEqual($request->requestMethod(), Bringit_Request::METHOD_PUT);
		$this->assertReference($request->url(), $url);
		$this->assertReference($request->header(), $header);
		$this->assertTrue($request->hasEntityBody(), 'should have entity body');
		$this->assertReference($request->entityBody(), $entityBody);
		$this->assertEqual($request->requestLine()->__toString(), "PUT /blarg HTTP/1.1\r\n");
		$this->assertEqual($header['Host'], 'example.org:81');
	}
}
