<?php

class Bringit_RequestDispatcherInternetTest extends UnitTestCase
{
	const TESTHOST = 'www.example.org';

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
			'#Example Web Page#',
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

		$this->assertWantedPattern(
			'#The requested method PUT is not allowed#',
			$responseBody
		);
	}
}
