<?php

/**
 * An HTTP request.
 * @see http://tools.ietf.org/html/rfc2616#section-5
 */
class Bringit_Request
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

	private
		$_requestMethod,
		$_url,
		$_header,
		$_entityBody;

	/**
	 * @param string $requestMethod
	 * @param Bringit_Url $url
	 * @param Bringit_Header_RequestHeader $header
	 * @param Bringit_EntityBody $entityBody
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
	 * @return Bringit_Header_RequestLine
	 */
	public function requestLine()
	{
		return new Bringit_Header_RequestLine(
			$this->requestMethod(),
			$this->url()->hostRelativeUrl(),
			self::HTTP_VERSION
		);
	}

	/**
	 * The method of the request.
	 * @see http://tools.ietf.org/html/rfc2616#section-5.1.1
	 * @return Bringit_RequestMethod
	 */
	public function requestMethod()
	{
		return $this->_requestMethod;
	}

	/**
	 * The URL addressing the resource to request.
	 * @return Bringit_Url
	 */
	public function url()
	{
		return $this->_url;
	}

	/**
	 * @return Bringit_Header_RequestHeader
	 */
	public function header()
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
	 * @return Bringit_EntityBody
	 */
	public function entityBody()
	{
		if (!$this->hasEntityBody())
			throw new Bringit_Exception('Request has no entity body');

		return $this->_entityBody;
	}

	// ----------------------------------------

	private function _setRequiredHeaders()
	{
		$header = $this->header();

		$header['Host'] = $this->url()->hostWithPort();

		if ($this->hasEntityBody())
			$header['Content-Length'] = $this->entityBody()->contentLength();
	}
}
