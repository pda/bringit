<?php

/**
 * An HTTP response.
 * @see http://tools.ietf.org/html/rfc2616#section-6
 */
class Bringit_Response
{
	private
		$_request,
		$_header,
		$_entityBody;

	/**
	 * @param Bringit_Url $request
	 * @param Bringit_Header_ResponseHeader $header
	 * @param Bringit_EntityBody $entityBody
	 */
	public function __construct($request, $header, $entityBody)
	{
		$this->_request = $request;
		$this->_header = $header;
		$this->_entityBody = $entityBody;
	}

	/**
	 * The original request.
	 * @return Bringit_Request
	 */
	public function request()
	{
		return $this->_request;
	}

	/**
	 * @return Bringit_Header_ResponseHeader
	 */
	public function header()
	{
		return $this->_header;
	}

	/**
	 * Whether the response has an Entity Body.
	 * @see http://tools.ietf.org/html/rfc2616#section-7.2
	 * @return bool
	 */
	public function hasEntityBody()
	{
		return isset($this->_entityBody);
	}

	/**
	 * The Entity Body of the Response.
	 * @see http://tools.ietf.org/html/rfc2616#section-7.2
	 * @return Bringit_EntityBody
	 */
	public function entityBody()
	{
		return $this->_entityBody;
	}

}
