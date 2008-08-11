<?php

/**
 * An entity body which uses a stream to get its body,
 * and does not support content encoding.
 */
class Phool_Body_SimpleEntityBody
	implements Phool_Body_EntityBody
{

	private $_stream;
	private $_contentType;
	private $_initialPosition;

	/**
	 * @param string $content The content
	 * @param string $contentType The MIME type of the content
	 */
	public function __construct($stream, $contentType)
	{
		$this->_stream = $stream;
		$this->_contentType = $contentType;
		$this->_initialPosition = ftell($stream);
	}

	/* (non-phpdoc)
	 * @see Phool_Body_EntityBody::hasContentEncoding()
	 */
	public function hasContentEncoding()
	{
		return false;
	}

	/* (non-phpdoc)
	 * @see Phool_Body_EntityBody::getContentEncoding()
	 */
	public function getContentEncoding()
	{
		throw new Phool_Exception(__CLASS__ . ' does not support content encoding.');
	}

	/* (non-phpdoc)
	 * @see Phool_Body_EntityBody::getContentLength()
	 */
	public function getContentLength()
	{
		// TODO: optimize for normal file streams using filesize()
		// TODO: cache result? - but something may write more to the stream
		$initialPosition = ftell($this->_stream);
		fseek($this->_stream, 0, SEEK_END);
		$endPosition = ftell($this->_stream);
		fseek($this->_stream, $initialPosition, SEEK_SET);
		return $endPosition - $initialPosition;
	}

	/* (non-phpdoc)
	 * @see Phool_Body_EntityBody::getContentType()
	 */
	public function getContentType()
	{
		return $this->_contentType;
	}

	/* (non-phpdoc)
	 * @see Phool_Body_EntityBody::getContentStream()
	 */
	public function getContentStream()
	{
		return $this->_stream;
	}

}