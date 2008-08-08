<?php

/**
 * Builds data for, and creates, a Phool_Request.
 */
class Phool_RequestBuilder
{

	private $_requestMethod;
	private $_url;
	private $_headerCollection;
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
		$this->_url = $url;
		return $this;
	}

	/**
	 * @param Phool_HeaderCollection
	 * @chainable
	 */
	public function setHeaderCollection($headerCollection)
	{
		$this->_headerCollection = $headerCollection;
		return $this;
	}

	/**
	 * @param Phool_EntityBody
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
		return new Phool_SimpleRequest(
			$this->_requestMethod,
			$this->_url,
			$this->_headerCollection,
			$this->_entityBody
		);
	}

}
