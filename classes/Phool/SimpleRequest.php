<?php

/**
 * An HTTP request.
 * @see http://tools.ietf.org/html/rfc2616#section-5
 */
class Phool_SimpleRequest
	implements Phool_Request
{

	private $_requestMethod;
	private $_url;
	private $_headerCollection;
	private $_entityBody;

	/**
	 * @param string $requestMethod
	 * @param Phool_Url $url
	 * @param Phool_HeaderCollection $headerCollection
	 * @param Phool_EntityBody $entityBody
	 */
	public function __construct($requestMethod, $url, $headerCollection, $entityBody)
	{
		$this->_requestMethod = $requestMethod;
		$this->_url = $url;
		$this->_headerCollection = $headerCollection;
		$this->_entityBody = $entityBody;
	}

	/* (non-phpdoc)
	 * @see Phool_Request::getRequestMethod()
	 */
	public function getRequestMethod()
	{
		return $this->_requestMethod;
	}

	/* (non-phpdoc)
	 * @see Phool_Request::getUrl()
	 */
	public function getUrl()
	{
		return $this->_url;
	}

	/* (non-phpdoc)
	 * @see Phool_Request::getHeaderCollection()
	 */
	public function getHeaderCollection()
	{
		return $this->_headerCollection;
	}

	/* (non-phpdoc)
	 * @see Phool_Request::hasEntityBody()
	 */
	public function hasEntityBody()
	{
		return isset($this->_entityBody);
	}

	/* (non-phpdoc)
	 * @see Phool_Request::getEntityBody()
	 */
	public function getEntityBody()
	{
		return $this->_entityBody;
	}

}