<?php

/**
 * A simple entity body which holds a string in memory as its content,
 * and does not support content encoding.
 */
class Phool_EntityBody_SimpleEntityBody
	implements Phool_EntityBody
{

	private $_contentType;
	private $_rawContent;
	private $_contentRead = false;

	/**
	 * @param string $content The content
	 * @param string $contentType The MIME type of the content
	 */
	public function __construct($content, $contentType)
	{
		$this->_rawContent = $content;
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
		return strlen($this->_rawContent);
	}

	public function getContentType()
	{
		return $this->_contentType;
	}

	public function hasData()
	{
		return !$this->_contentRead;
	}

	public function getData()
	{
		if ($this->hasData())
		{
			$this->_contentRead = true;
			return $this->_rawContent;
		}
		else
		{
			return null;
		}
	}

	public function rewindData()
	{
		$this->_contentRead = false;
	}

}

?>