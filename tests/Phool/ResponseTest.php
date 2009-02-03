<?php

require_once('mock_objects.php');

Mock::generate('Phool_Request', 'MockRequest');
Mock::generate('Phool_Header_ResponseHeader', 'ResponseHeader');
Mock::generate('Phool_Body_EntityBody', 'MockEntityBody');

class Phool_ResponseTest extends UnitTestCase
{
	public function testResponse()
	{
		$request = new MockRequest();
		$header = new ResponseHeader();
		$body = new MockEntityBody();

		$response = new Phool_Response($request, $header, $body);

		$this->assertTrue($response->hasEntityBody());

		$this->assertReference($response->request(), $request);
		$this->assertReference($response->header(), $header);
		$this->assertReference($response->entityBody(), $body);
	}
}
