<?php

class Phool_RequestDispatcherReflectorTest extends UnitTestCase
{
	const TESTHOST = 'localhost:10080';

	public function testDispatchBasicGetRequest()
	{
		$builder = new Phool_RequestBuilder();
		$request = $builder
			->method(Phool_Request::METHOD_GET)
			->url('http://'.self::TESTHOST.'/')
			->header(new Phool_Header_RequestHeader())
			->create();

		$dispatcher = new Phool_RequestDispatcher();
		$response = $dispatcher->dispatch($request);

		$responseBody = $response->entityBody()->contentString();

		$this->assertWantedPattern(
			'#^GET / HTTP/1.1\r\n#',
			$responseBody
		);

		$this->assertWantedPattern(
			'#Host: '.self::TESTHOST.'\r\n#',
			$responseBody
		);
	}

	public function testDispatchPutRequest()
	{
		$entityBodyFactory = new Phool_EntityBodyFactory();
		$body = $entityBodyFactory->createFromString('test content');

		$header = new Phool_Header_RequestHeader();

		$builder = new Phool_RequestBuilder();
		$request = $builder
			->method(Phool_Request::METHOD_PUT)
			->url('http://'.self::TESTHOST.'/test')
			->header($header)
			->body($body)
			->create();

		$dispatcher = new Phool_RequestDispatcher();
		$response = $dispatcher->dispatch($request);

		$responseBody = $response->entityBody()->contentString();

		$host = self::TESTHOST;
		$this->assertEqual(
			"PUT /test HTTP/1.1\r\n" .
			"Host: $host\r\n" .
			"Content-Length: 12\r\n" .
			"\r\n" .
			"test content",
			$responseBody
		);
	}
}
