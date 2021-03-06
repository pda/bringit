<?php

/**
 * Serializes a RequestHeader into a string.
 */
class Bringit_Header_RequestHeaderSerializer
{
	private $_header;

	/**
	 * @param Bringit_Header_RequestHeader
	 */
	public function __construct($requestHeader)
	{
		$this->_header = $requestHeader;
	}

	/**
	 * Serializes the header  into a string.
	 * @return string
	 */
	public function serialize()
	{
		return implode('', $this->_header->fields()) . "\r\n";
	}
}
