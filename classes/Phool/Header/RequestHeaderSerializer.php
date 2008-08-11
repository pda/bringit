<?php

/**
 * Serializes a RequestHeader into a string.
 */
class Phool_Header_RequestHeaderSerializer
{

	private $_header;

	/**
	 * @param Phool_Header_Header
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
		return implode('', $this->_header->getHeaders()) . "\r\n";
	}

}
