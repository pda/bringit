<?php

require_once('mock_objects.php');

Mock::generate('Bringit_Request', 'MockRequest');
Mock::generate('Bringit_Header_ResponseHeader', 'ResponseHeader');
Mock::generate('Bringit_EntityBody', 'MockEntityBody');

class Bringit_ResponseTest extends UnitTestCase
{
	public function testResponse()
	{
		$request = new MockRequest();
		$header = new ResponseHeader();
		$body = new MockEntityBody();

		$response = new Bringit_Response($request, $header, $body);

		$this->assertTrue($response->hasEntityBody());

		$this->assertReference($response->request(), $request);
		$this->assertReference($response->header(), $header);
		$this->assertReference($response->entityBody(), $body);
	}
}
