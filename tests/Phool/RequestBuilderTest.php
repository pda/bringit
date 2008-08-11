<?php

class Phool_RequestBuilderTest extends PhoolTestCase
{

	public function testBasicUsage()
	{
		$builder = new Phool_RequestBuilder();

		$method = Phool_Request::METHOD_PUT;
		$url = new Phool_Url('http://example.org/');
		$header = new Phool_Header_RequestHeader();

		$entityBodyFactory = new Phool_Body_EntityBodyFactory();
		$entityBody = $entityBodyFactory->createFromString('', 'text/plain');

		$builder
			->setRequestMethod($method)
			->setUrl($url)
			->setHeader($header)
			->setEntityBody($entityBody);

		$request = $builder->createRequest();

		$this->assertIsA($request, 'Phool_Request');

		$this->assertEqual($request->getRequestMethod(), $method);
		$this->assertReference($request->getUrl(), $url);
		$this->assertReference($request->getHeader(), $header);
		$this->assertReference($request->getEntityBody(), $entityBody);
	}

}
