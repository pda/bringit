<?php

/**
 * The body of an HTTP request.
 * @see {@link http://tools.ietf.org/html/rfc1945#section-7.2}
 */
interface Phool_Body_EntityBody
{

	/**
	 * Whether the content of the EntityBody is encoded.
	 * @see {@link http://tools.ietf.org/html/rfc1945#section-10.3}
	 * @return bool
	 */
	public function hasContentEncoding();

	/**
	 * The encoding used for the content of the Entity-Body.
	 * @see {@link http://tools.ietf.org/html/rfc1945#section-10.3}
	 * @return string
	 */
	public function getContentEncoding();

	/**
	 * The size of the Entity-Body, in decimal number of octets.
	 * @see {@link http://tools.ietf.org/html/rfc1945#section-10.4}
	 * @return int
	 */
	public function getContentLength();

	/**
	 * The media type of the Entity-Body.
	 * @see {@link http://tools.ietf.org/html/rfc1945#section-10.5}
	 * @return string
	 */
	public function getContentType();

	/**
	 * The file-stream of the EntityBody content.
	 * @return resource stream
	 */
	public function getContentStream();

}
