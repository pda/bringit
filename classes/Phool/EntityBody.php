<?php

/**
 * The body of an HTTP request.
 * @see {@link http://tools.ietf.org/html/rfc1945#section-7.2}
 */
interface Phool_EntityBody
{

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
	 * Whether the entity body has unread data remaining.
	 * @return boolean
	 */
	public function hasData();

	/**
	 * Gets the next chunk of unread data. Returns null if no data remaining.
	 * @return string
	 */
	public function getData();

	/**
	 * Rewinds to the original position in the data.
	 */
	public function rewindData();

}

?>
