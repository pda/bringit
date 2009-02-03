<?php

class Phool_RequestDispatcherInternetTest extends UnitTestCase
{
	const TESTHOST = 'www.example.org';

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
			'#Example Web Page#',
			$responseBody
		);
	}

	public function testDispatchPutRequest()
	{
		$entityBodyFactory = new Phool_Body_EntityBodyFactory();
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

		$this->assertWantedPattern(
			'#The requested method PUT is not allowed#',
			$responseBody
		);
	}
}
