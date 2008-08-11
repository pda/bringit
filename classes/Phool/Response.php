<?php

/**
 * An HTTP response.
 * @see http://tools.ietf.org/html/rfc2616#section-6
 */
class Phool_Response
{

	private $_request;
	private $_header;
	private $_entityBody;

	/**
	 * @param Phool_Url $request
	 * @param Phool_Header $header
	 * @param Phool_Body_EntityBody $entityBody
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
	public function getRequest()
	{
		return $this->_request;
	}

	/**
	 * @return Phool_Header_ResponseHeader
	 */
	public function getResponseHeader()
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
	 * @return Phool_Body_EntityBody
	 */
	public function getEntityBody()
	{
		return $this->_entityBody;
	}

}