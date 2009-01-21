<?php

/**
 * Creates EntityBody instances from different types of content source.
 */
class Phool_Body_EntityBodyFactory
{
	/**
	 * Creates an EntityBody using a stream as the content source.
	 * @param resource $contentStream
	 */
	public function createFromStream($contentStream)
	{
		return new Phool_Body_SimpleEntityBody($contentStream);
	}

	/**
	 * Creates an EntityBody from a string of content.
	 * @param string $contentString
	 */
	public function createFromString($contentString)
	{
		$stream = fopen('php://memory', 'w');
		fwrite($stream, $contentString);
		rewind($stream);
		return $this->createFromStream($stream);
	}

	/**
	 * Creates an EntityBody using a file as the content source.
	 * @param string $filePath
	 */
	public function createFromFile($filePath)
	{
		return $this->createFromStream(fopen($filePath, 'r'));
	}
}
