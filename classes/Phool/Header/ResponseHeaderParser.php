<?php

/**
 * Parses an HTTP response header string into a ResponseHeader
 */
class Phool_Header_ResponseHeaderParser
{
	/**
	 * @param mixed
	 * @return Phool_Header_ResponseHeader
	 */
	public function parse($source)
	{
		if (is_resource($source))
			return $this->parseStream($source);
		elseif (is_string($source))
			return $this->parseString($source);
		elseif (is_object($source) && is_callable(array($source, '__toString')))
			return $this->parseString($source->__toString());
		else
			throw new Phool_Exception('source is neither resource nor stream.');
	}

	/**
	 * @param string $headerString
	 * @return Phool_Header_ResponseHeader
	 */
	public function parseString($headerString)
	{
		return $this->parseStream($this->_stringToStream($headerString));
	}

	/**
	 * @param resource a file stream
	 * @return Phool_Header_ResponseHeader
	 */
	public function parseStream($stream)
	{
		$statusLine = Phool_Header_ResponseStatusLine::fromString(fgets($stream));

		// TODO: handle folding/continuation
		// @see http://tools.ietf.org/html/rfc2616#section-2.2
		$headers = array();
		while (!feof($stream))
		{
			$line = fgets($stream);
			if ($line === "\r\n") break;
			else $headers []= Phool_Header_HeaderField::fromString($line);
		}

		return new Phool_Header_ResponseHeader($statusLine, $headers);
	}

	// ----------------------------------------

	/**
	 * @param string
	 * @return resource stream
	 */
	private function _stringToStream($string)
	{
		$stream = fopen('php://memory', 'w');
		fwrite($stream, $string);
		rewind($stream);
		return $stream;
	}

	/**
	 * Whether the line is an HTTP response status line.
	 * @param string
	 * @return bool
	 */
	private function _isStatusLine($line)
	{
		try
		{
			Phool_Header_ResponseStatusLine::fromString($line);
			return true;
		}
		catch (Phool_Exception $e)
		{
			return false;
		}
	}
}
