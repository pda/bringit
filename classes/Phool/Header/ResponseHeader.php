<?php

/**
 * The header of an HTTP response, including the status line and header fields.
 * Header field names/keys are case insensitive and non-unique in the .
 */
class Phool_Header_ResponseHeader
{

	private $_headers = array();
	private $_statusLine;

	/**
	 * @param Phool_Header_ResponseStatusLine, may be null
	 * @param Phool_Header[] $headers
	 */
	public function __construct($statusLine, $headers)
	{
		$this->_statusLine = $statusLine;
		$this->_headers = $headers;
	}

	/**
	 * Whether the  contains an HTTP response status line.
	 * @see http://tools.ietf.org/html/rfc2616#section-6.1
	 * @return bool
	 */
	public function hasStatusLine()
	{

	}
	/**
	 * The HTTP response status line.
	 * @see http://tools.ietf.org/html/rfc2616#section-6.1
	 * @return Phool_Header_ResponseStatusLine
	 */
	public function getStatusLine()
	{
		return $this->_statusLine;
	}

	/**
	 * @return Phool_Header[]
	 */
	public function getHeaders()
	{
		return $this->_headers;
	}

}