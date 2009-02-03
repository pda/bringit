<?php

/**
 * The request line of an HTTP request.
 * @see http://tools.ietf.org/html/rfc2616#section-5.1
 */
class Phool_Header_RequestLine
{
	private
		$_requestMethod,
		$_requestUri,
		$_httpVersion;

	/**
	 * @param string $requestMethod
	 * @param string $requestUri
	 * @param string $httpVersion
	 */
	public function __construct($requestMethod, $requestUri, $httpVersion)
	{
		$this->_requestMethod = $requestMethod;
		$this->_requestUri = $requestUri;
		$this->_httpVersion = $httpVersion;
	}

	/**
	 * @return string
	 */
	public function reqestMethod()
	{
		return $this->_requestMethod;
	}

	/**
	 * @return string
	 */
	public function reqestUri()
	{
		return $this->_requestUri;
	}

	/**
	 * @return string
	 */
	public function httpVersion()
	{
		return $this->_httpVersion;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return sprintf("%s %s HTTP/%s\r\n",
			$this->reqestMethod(),
			$this->reqestUri(),
			$this->httpVersion()
		);
	}

	/**
	 * @param string $statusLine
	 * @return Phool_Header_RequestLine
	 */
	public static function fromString($requestLine)
	{
		$regex = '#^([A-Z]+)\s+(\S+) HTTP/(\d+\.\d+)[\r\n]{0,2}$#';

		if (!preg_match($regex, $requestLine, $matches))
			throw new Phool_Exception("Malformed request line: '$requestLine'");

		list(, $requestMethod, $requestUrl, $httpVersion) = $matches;
		return new self($requestMethod, $requestUrl, $httpVersion);
	}
}
