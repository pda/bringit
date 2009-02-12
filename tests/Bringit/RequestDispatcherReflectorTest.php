<?php

class Bringit_RequestDispatcherReflectorTest extends UnitTestCase
{
	const TESTHOST = 'localhost:10080';

	public function testDispatchBasicGetRequest()
	{
		$builder = new Bringit_RequestBuilder();
		$request = $builder
			->method(Bringit_Request::METHOD_GET)
			->url('http://'.self::TESTHOST.'/')
			->header(new Bringit_Header_RequestHeader())
			->create();

		$dispatcher = new Bringit_RequestDispatcher();
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
		$entityBodyFactory = new Bringit_EntityBodyFactory();
		$body = $entityBodyFactory->createFromString('test content');

		$header = new Bringit_Header_RequestHeader();

		$builder = new Bringit_RequestBuilder();
		$request = $builder
			->method(Bringit_Request::METHOD_PUT)
			->url('http://'.self::TESTHOST.'/test')
			->header($header)
			->body($body)
			->create();

		$dispatcher = new Bringit_RequestDispatcher();
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
