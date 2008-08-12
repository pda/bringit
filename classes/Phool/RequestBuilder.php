<?php

/**
 * Builds data for, and creates, a Phool_Request.
 */
class Phool_RequestBuilder
{

	private $_requestMethod = Phool_Request::METHOD_GET;
	private $_url;
	private $_header;
	private $_entityBody;

	/**
	 * @param Phool_RequestMethod
	 * @chainable
	 */
	public function setRequestMethod($requestMethod)
	{
		$this->_requestMethod = $requestMethod;
		return $this;
	}

	/**
	 * @param Phool_Url
	 * @chainable
	 */
	public function setUrl($url)
	{
		$this->_url = is_string($url) ? new Phool_Url($url) : $url;
		return $this;
	}

	/**
	 * @param Phool_Header
	 * @chainable
	 */
	public function setHeader($header)
	{
		$this->_header = $header;
		return $this;
	}

	/**
	 * @param Phool_Body_EntityBody
	 * @chainable
	 */
	public function setEntityBody($entityBody)
	{
		$this->_entityBody = $entityBody;
		return $this;
	}

	/**
	 * Builds the request based on the data passed to the setter methods.
	 * @return Phool_Request
	 */
	public function createRequest()
	{
		return new Phool_Request(
			$this->_requestMethod,
			$this->_getUrl(),
			$this->_getHeader(),
			$this->_entityBody
		);
	}

	// ----------------------------------------

	/**
	 * Gets the RequestHeader, creating a new one if none set.
	 * @return Phool_Header_RequestHeader
	 */
	private function _getHeader()
	{
		if (!isset($this->_header))
			$this->_header = new Phool_Header_RequestHeader();

		return $this->_header;
	}

	/**
	 * Gets the URL, throws exception if none set.
	 * @return Phool_Url
	 * @throws Phool_Exception if no URL set/
	 */
	private function _getUrl()
	{
		if (!isset($this->_url)) throw new Phool_Exception(
			'Cannot build request without URL');

		return $this->_url;
	}
}
