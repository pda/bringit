<?php

/**
 * An HTTP response.
 * @see http://tools.ietf.org/html/rfc2616#section-6
 */
class Phool_Response
{
	private
		$_request,
		$_header,
		$_entityBody;

	/**
	 * @param Phool_Url $request
	 * @param Phool_Header_ResponseHeader $header
	 * @param Phool_EntityBody $entityBody
	 */
	public function __construct($request, $header, $entityBody)
	{
		$this->_request = $request;
		$this->_header = $header;
		$this->_entityBody = $entityBody;
	}

	/**
	 * The original request.
	 * @return Phool_Request
	 */
	public function request()
	{
		return $this->_request;
	}

	/**
	 * @return Phool_Header_ResponseHeader
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
	 * @return Phool_EntityBody
	 */
	public function entityBody()
	{
		return $this->_entityBody;
	}

}