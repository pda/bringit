<?php

/**
 * An entity body which uses a stream to get its body,
 * and does not support content encoding.
 */
class Phool_EntityBody_StreamEntityBody
	implements Phool_EntityBody
{

	const GETDATA_SIZE = 1024;

	private $_contentType;
	private $_stream;
	private $_initialPosition;

	/**
	 * @param string $content The content
	 * @param string $contentType The MIME type of the content
	 */
	public function __construct($stream, $contentType)
	{
		$this->_stream = $stream;
		$this->_initialPosition = ftell($stream);
		$this->_contentType = $contentType;
	}

	/**
	 * This implementation does not support content encoding.
	 */
	public function getContentEncoding()
	{
		return null;
	}

	public function getContentLength()
	{
		// TODO: optimize for files using filesize()

		$initialPosition = ftell($this->_stream);
		fseek($this->_stream, 0, SEEK_END);
		$endPosition = ftell($this->_stream);
		fseek($this->_stream, $initialPosition, SEEK_SET);
		return $endPosition - $this->_initialPosition;
	}

	public function getContentType()
	{
		return $this->_contentType;
	}

	public function hasData()
	{
		return !feof($this->_stream);
	}

	public function getData()
	{
		if ($this->hasData())
		{
			return fread($this->_stream, self::GETDATA_SIZE);
		}
		else
		{
			return null;
		}
	}

	public function rewindData()
	{
		fseek($this->_stream, $this->_initialPosition, SEEK_SET);
	}

}

?>