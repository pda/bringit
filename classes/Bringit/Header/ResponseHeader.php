<?php

/**
 * The header of an HTTP response, including the status line and header fields.
 * Header field names/keys are case insensitive and non-unique.
 */
class Bringit_Header_ResponseHeader
{
	private
		$_fields = array(),
		$_statusLine;

	/**
	 * @param Bringit_Header_ResponseStatusLine, may be null
	 * @param Bringit_Header_HeaderField[] $fields
	 */
	public function __construct($statusLine, $fields)
	{
		$this->_statusLine = $statusLine;
		$this->_fields = $fields;
	}

	/**
	 * The HTTP response status line.
	 * @see http://tools.ietf.org/html/rfc2616#section-6.1
	 * @return Bringit_Header_ResponseStatusLine
	 */
	public function statusLine()
	{
		return $this->_statusLine;
	}

	/**
	 * @return Bringit_Header_HeaderField[]
	 */
	public function fields()
	{
		return $this->_fields;
	}
}
