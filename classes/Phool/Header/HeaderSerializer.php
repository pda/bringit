<?php

/**
 * Serializes a collection of headers into a single string.
 */
class Phool_Header_HeaderSerializer
{

	private $_headerCollection;

	/**
	 * @param Phool_Header_HeaderCollection
	 */
	public function __construct(Phool_Header_HeaderCollection $headerCollection)
	{
		$this->_headerCollection = $headerCollection;
	}

	/**
	 * Serializes the header collection into a string.
	 * @return string
	 */
	public function serialize()
	{
		return implode('', $this->_headerCollection->getHeaders());
	}

}
