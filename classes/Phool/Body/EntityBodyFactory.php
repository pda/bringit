<?php

/**
 * Creates EntityBody instances from different types of content source.
 */
class Phool_Body_EntityBodyFactory
{

	/**
	 * Creates an EntityBody using a stream as the content source.
	 * @param resource $contentStream
	 * @param string $contentType The content MIME type.
	 */
	public function createFromStream($contentStream, $contentType)
	{
		return new Phool_Body_SimpleEntityBody($contentStream, $contentType);
	}

	/**
	 * Creates an EntityBody from a string of content.
	 * @param string $contentString
	 * @param string $contentType The content MIME type.
	 */
	public function createFromString($contentString, $contentType)
	{
		$stream = fopen('php://memory', 'w');
		fwrite($stream, $contentString);
		rewind($stream);
		return $this->createFromStream($stream, $contentType);
	}

	/**
	 * Creates an EntityBody using a file as the content source.
	 * @param string $filePath
	 * @param string $contentType The content MIME type.
	 */
	public function createFromFile($filePath, $contentType)
	{
		return $this->createFromStream(fopen($filePath, 'r'), $contentType);
	}

}
