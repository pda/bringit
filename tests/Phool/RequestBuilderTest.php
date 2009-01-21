<?php

class Phool_RequestBuilderTest extends PhoolTestCase
{
	public function testBasicGetRequest()
	{
		$builder = new Phool_RequestBuilder();
		$request = $builder->setUrl('http://example.org/')->createRequest();

		$this->assertIsA($request, 'Phool_Request');
		$this->assertEqual($request->getRequestMethod(), Phool_Request::METHOD_GET);
		$this->assertEqual($request->getUrl()->__toString(), 'http://example.org/');
		$this->assertFalse($request->hasEntityBody(), 'should not have entity body');

		$this->assertEqual($request->getRequestLine()->__toString(), "GET / HTTP/1.1\r\n");
		$this->assertIsA($request->getHeader(), 'Phool_Header_RequestHeader');
		$this->assertEqual($request->getHeader()->getHeaderValue('Host'), 'example.org');
	}

	public function testBuildWithoutUrlThrowsException()
	{
		$builder = new Phool_RequestBuilder();
		$this->expectException('Phool_Exception');
		$builder->createRequest();
	}

	public function testRequestBuiltWithoutEntityBodyThrowsException()
	{
		$builder = new Phool_RequestBuilder();
		$request = $builder->setUrl('http://example.org/')->createRequest();

		$this->expectException('Phool_Exception');
		$request->getEntityBody();
	}

	public function testPutRequest()
	{
		$builder = new Phool_RequestBuilder();

		$url = new Phool_Url('http://example.org:81/blarg');
		$header = new Phool_Header_RequestHeader();
		$header['Content-Type'] = 'text/plain';

		$entityBodyFactory = new Phool_Body_EntityBodyFactory();
		$entityBody = $entityBodyFactory->createFromString('testing');

		$builder
			->setRequestMethod(Phool_Request::METHOD_PUT)
			->setUrl($url)
			->setHeader($header)
			->setEntityBody($entityBody);

		$request = $builder->createRequest();

		$this->assertIsA($request, 'Phool_Request');

		$this->assertEqual($request->getRequestMethod(), Phool_Request::METHOD_PUT);
		$this->assertReference($request->getUrl(), $url);
		$this->assertReference($request->getHeader(), $header);
		$this->assertTrue($request->hasEntityBody(), 'should have entity body');
		$this->assertReference($request->getEntityBody(), $entityBody);
		$this->assertEqual($request->getRequestLine()->__toString(), "PUT /blarg HTTP/1.1\r\n");
		$this->assertEqual($header['Host'], 'example.org:81');
	}
}
