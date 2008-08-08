<?php

/**
 * A collection of headers belonging to an HTTP response.
 * Header names/keys are case insensitive and non-unique in the collection.
 */
class Phool_Header_ResponseHeaderCollection
	implements Phool_Header_HeaderCollection
{

	private $_headers = array();

	/**
	 * @param Phool_Header[] $headers
	 */
	public function __construct($headers)
	{
		$this->_headers = $headers;
	}

	/* (non-phpdoc)
	 * @see Phool_Header_HeaderCollection::getHeaders()
	 */
	public function getHeaders()
	{
		return $this->_headers;
	}

	/* (non-phpdoc)
	 * @see Phool_Header_HeaderCollection::__toString()
	 */
	public function __toString()
	{
		$serializer = new Phool_Header_HeaderSerializer($this);
		return $serializer->serialize();
	}

}