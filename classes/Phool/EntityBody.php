<?php

/**
 * The body of an HTTP request.
 * @see {@link http://tools.ietf.org/html/rfc1945#section-7.2}
 *
 * This implementation uses a stream to get its body,
 * and does not support content encoding.
 */
class Phool_EntityBody
{
	private
		$_stream,
		$_memoryStream,
		$_initialPosition;

	/**
	 * @param string $content The content
	 * @param string $contentType The MIME type of the content
	 */
	public function __construct($stream)
	{
		$this->_stream = $stream;
		$this->_initialPosition = ftell($stream);
	}

	/**
	 * The size of the Entity-Body, in decimal number of octets.
	 * @see {@link http://tools.ietf.org/html/rfc1945#section-10.4}
	 * @return int
	 */
	public function contentLength()
	{
		// TODO: optimize for normal file streams using filesize()
		// TODO: cache result? - but something may write more to the stream
		$initialPosition = ftell($this->_stream);
		fseek($this->_stream, 0, SEEK_END);
		$endPosition = ftell($this->_stream);
		fseek($this->_stream, $initialPosition, SEEK_SET);
		return $endPosition - $initialPosition;
	}

	/**
	 * The file-stream of the EntityBody content.
	 * @return resource stream
	 */
	public function contentStream()
	{
		return $this->_stream;
	}

	/**
	 * Loads content into memory.
	 * @chainable
	 */
	public function loadContent()
	{
		// replace original stream with memory stream
		if (!isset($this->_memoryStream))
		{
			$source = $this->_stream;
			$this->_memoryStream = fopen('php://memory', 'w');
			while (!feof($source)) fwrite($this->_memoryStream, fread($source, 1024));
			rewind($this->_memoryStream);
			$this->_stream = $this->_memoryStream;
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function contentString()
	{
		$this->loadContent();
		$string = '';
		$pos = ftell($this->_stream);
		rewind($this->_stream);
		while (!feof($this->_stream)) $string .= fread($this->_stream, 1024);
		fseek($this->_stream, $pos, SEEK_SET);
		return $string;
	}
}