<?php

class Phool_RequestDispatcherInternetTest extends UnitTestCase
{

	const TESTHOST = 'www.example.org';

	public function testDispatchBasicGetRequest()
	{
		$builder = new Phool_RequestBuilder();
		$request = $builder
			->setRequestMethod(Phool_Request::METHOD_GET)
			->setUrl('http://'.self::TESTHOST.'/')
			->setHeader(new Phool_Header_RequestHeader())
			->createRequest();

		$dispatcher = new Phool_RequestDispatcher();
		$response = $dispatcher->dispatch($request);

		$responseBody = $response->getEntityBody()->getContentString();

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
			->setRequestMethod(Phool_Request::METHOD_PUT)
			->setUrl('http://'.self::TESTHOST.'/test')
			->setHeader($header)
			->setEntityBody($body)
			->createRequest();

		$dispatcher = new Phool_RequestDispatcher();
		$response = $dispatcher->dispatch($request);

		$responseBody = $response->getEntityBody()->getContentString();

		$this->assertWantedPattern(
			'#The requested method PUT is not allowed#',
			$responseBody
		);
	}

}
