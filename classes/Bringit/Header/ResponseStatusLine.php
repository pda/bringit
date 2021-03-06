<?php

/**
 * The status line of an HTTP response.
 * @see http://tools.ietf.org/html/rfc2616#section-6.1
 */
class Bringit_Header_ResponseStatusLine
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
	public function httpVersion()
	{
		return $this->_httpVersion;
	}

	/**
	 * @return int
	 */
	public function responseCode()
	{
		return $this->_responseCode;
	}

	/**
	 * @return string
	 */
	public function reasonPhrase()
	{
		return $this->_reasonPhrase;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return sprintf("HTTP/%s %d %s\r\n",
			$this->httpVersion(),
			$this->responseCode(),
			$this->reasonPhrase()
		);
	}

	/**
	 * @param string $statusLine
	 * @return Bringit_Header_ResponseStatusLine
	 */
	public static function fromString($statusLine)
	{
		$regex = '#^HTTP/(\d+\.\d+)\s+(\d{3})\s+([^\r\n]*)[\r\n]{0,2}$#';

		if (!preg_match($regex, $statusLine, $matches))
			throw new Bringit_Exception("Malformed status line: '$statusLine'");

		list(, $httpVersion, $statusCode, $reasonPhrase) = $matches;
		return new self($httpVersion, $statusCode, $reasonPhrase);
	}
}
