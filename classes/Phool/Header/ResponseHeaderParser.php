<?php

/**
 * Parses an HTTP response header string into a ResponseHeader
 */
class Phool_Header_ResponseHeaderParser
{

	/**
	 * @param string $headerString
	 * @return Phool_Header_ResponseHeader
	 */
	public function parse($headerString)
	{
		$stream = $this->_stringToStream($headerString);

		$headers = array();
		$statusLine = null;

		// TODO: handle folding/continuation
		// @see http://tools.ietf.org/html/rfc2616#section-2.2
		while (!feof($stream))
		{
			$line = fgets($stream);

			if ($this->_isStatusLine($line))
				$statusLine = Phool_Header_ResponseStatusLine::fromString($line);
			else
				$headers []= Phool_Header_HeaderField::fromString($line);
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
