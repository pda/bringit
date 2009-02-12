<?php

/**
 * Builds data for, and creates, a Bringit_Request.
 */
class Bringit_RequestBuilder
{
	private
		$_requestMethod = Bringit_Request::METHOD_GET,
		$_url,
		$_header,
		$_entityBody;

	/**
	 * @param Bringit_RequestMethod
	 * @chainable
	 */
	public function method($requestMethod)
	{
		$this->_requestMethod = $requestMethod;
		return $this;
	}

	/**
	 * @param Bringit_Url
	 * @chainable
	 */
	public function url($url)
	{
		$this->_url = is_string($url) ? new Bringit_Url($url) : $url;
		return $this;
	}

	/**
	 * @param Bringit_Header
	 * @chainable
	 */
	public function header($header)
	{
		$this->_header = $header;
		return $this;
	}

	/**
	 * @param Bringit_EntityBody
	 * @chainable
	 */
	public function body($entityBody)
	{
		$this->_entityBody = $entityBody;
		return $this;
	}

	/**
	 * Builds the request based on the data passed to the setter methods.
	 * @return Bringit_Request
	 */
	public function create()
	{
		return new Bringit_Request(
			$this->_requestMethod,
			$this->_getUrl(),
			$this->_getHeader(),
			$this->_entityBody
		);
	}

	// ----------------------------------------

	/**
	 * Gets the RequestHeader, creating a new one if none set.
	 * @return Bringit_Header_RequestHeader
	 */
	private function _getHeader()
	{
		if (!isset($this->_header))
			$this->_header = new Bringit_Header_RequestHeader();

		return $this->_header;
	}

	/**
	 * Gets the URL, throws exception if none set.
	 * @return Bringit_Url
	 * @throws Bringit_Exception if no URL set/
	 */
	private function _getUrl()
	{
		if (!isset($this->_url)) throw new Bringit_Exception(
			'Cannot build request without URL');

		return $this->_url;
	}
}
