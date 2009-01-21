<?php

/**
 * The status line of an HTTP response.
 * @see http://tools.ietf.org/html/rfc2616#section-6.1
 */
class Phool_Header_ResponseStatusLine
{
	private
		$_httpVersion,
		$_responseCode,
		$_reasonPhrase;

	/**
	 * @param string $httpVersion
	 * @param int $responseCode
	 * @param string $reasonPhrase
	 */
	public function __construct($httpVersion, $responseCode, $reasonPhrase)
	{
		$this->_httpVersion = $httpVersion;
		$this->_responseCode = $responseCode;
		$this->_reasonPhrase = $reasonPhrase;
	}

	/**
	 * @return string
	 */
	public function getHttpVersion()
	{
		return $this->_httpVersion;
	}

	/**
	 * @return int
	 */
	public function getResponseCode()
	{
		return $this->_responseCode;
	}

	/**
	 * @return string
	 */
	public function getReasonPhrase()
	{
		return $this->_reasonPhrase;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return sprintf("HTTP/%s %d %s\r\n",
			$this->getHttpVersion(),
			$this->getResponseCode(),
			$this->getReasonPhrase()
		);
	}

	/**
	 * @param string $statusLine
	 * @return Phool_Header_ResponseStatusLine
	 */
	public static function fromString($statusLine)
	{
		$regex = '#^HTTP/(\d+\.\d+)\s+(\d{3})\s+([^\r\n]*)[\r\n]{0,2}$#';

		if (!preg_match($regex, $statusLine, $matches))
			throw new Phool_Exception("Malformed status line: '$statusLine'");

		list(, $httpVersion, $statusCode, $reasonPhrase) = $matches;
		return new self($httpVersion, $statusCode, $reasonPhrase);
	}
}
