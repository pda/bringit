<?php

class Phool_RequestBuilderTest extends PhoolTestCase
{

	public function testBasicUsage()
	{
		$builder = new Phool_RequestBuilder();

		$method = Phool_Request::METHOD_PUT;
		$url = new Phool_Url('http://example.org/');
		$headerCollection = new Phool_Header_RequestHeaderCollection();
		$entityBody = new Phool_EntityBody_SimpleEntityBody('', 'text/plain');

		$builder
			->setRequestMethod($method)
			->setUrl($url)
			->setHeaderCollection($headerCollection)
			->setEntityBody($entityBody);

		$request = $builder->createRequest();

		$this->assertIsA($request, 'Phool_Request');

		$this->assertEqual($request->getRequestMethod(), $method);
		$this->assertReference($request->getUrl(), $url);
		$this->assertReference($request->getHeaderCollection(), $headerCollection);
		$this->assertReference($request->getEntityBody(), $entityBody);
	}

}
