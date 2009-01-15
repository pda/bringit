<?php

/**
 * An HTTP request.
 * @see http://tools.ietf.org/html/rfc2616#section-5
 */
class Phool_Request
{

	const METHOD_OPTIONS = 'OPTIONS';
	const METHOD_GET = 'GET';
	const METHOD_HEAD = 'HEAD';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';
	const METHOD_TRACE = 'TRACE';
	const METHOD_CONNECT = 'CONNECT';

	const HTTP_VERSION = '1.1';

	private $_requestMethod;
	private $_url;
	private $_header;
	private $_entityBody;

	/**
	 * @param string $requestMethod
	 * @param Phool_Url $url
	 * @param Phool_Header $header
	 * @param Phool_Body_EntityBody $entityBody
	 */
	public function __construct($requestMethod, $url, $header, $entityBody)
	{
		$this->_requestMethod = $requestMethod;
		$this->_url = $url;
		$this->_header = $header;
		$this->_entityBody = $entityBody;
		$this->_setRequiredHeaders();
	}

	/**
	 * @return Phool_Header_RequestLine
	 */
	public function getRequestLine()
	{
		return new Phool_Header_RequestLine(
			$this->getRequestMethod(),
			$this->getUrl()->getHostRelativeUrl(),
			self::HTTP_VERSION
		);
	}

	/**
	 * The method of the request.
	 * @see http://tools.ietf.org/html/rfc2616#section-5.1.1
	 * @return Phool_RequestMethod
	 */
	public function getRequestMethod()
	{
		return $this->_requestMethod;
	}

	/**
	 * The URL addressing the resource to request.
	 * @return Phool_Url
	 */
	public function getUrl()
	{
		return $this->_url;
	}

	/**
	 * @return Phool_Header_RequestHeader
	 */
	public function getHeader()
	{
		return $this->_header;
	}

	/**
	 * Whether the request has an Entity Body.
	 * @see http://tools.ietf.org/html/rfc2616#section-7.2
	 * @return bool
	 */
	public function hasEntityBody()
	{
		return isset($this->_entityBody);
	}

	/**
	 * The Entity Body of the Request.
	 * @see http://tools.ietf.org/html/rfc2616#section-7.2
	 * @return Phool_Body_EntityBody
	 */
	public function getEntityBody()
	{
		if (!$this->hasEntityBody())
			throw new Phool_Exception('Request has no entity body');

		return $this->_entityBody;
	}

	// ----------------------------------------

	private function _setRequiredHeaders()
	{
		$header = $this->getHeader();

		$header['Host'] = $this->getUrl()->getHostWithPort();

		if ($this->hasEntityBody())
			$header['Content-Length'] = $this->getEntityBody()->getContentLength();
	}
}