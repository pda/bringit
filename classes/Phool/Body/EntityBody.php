<?php

/**
 * The body of an HTTP request.
 * @see {@link http://tools.ietf.org/html/rfc1945#section-7.2}
 */
interface Phool_Body_EntityBody
{

	/**
	 * The size of the Entity-Body, in decimal number of octets.
	 * @see {@link http://tools.ietf.org/html/rfc1945#section-10.4}
	 * @return int
	 */
	public function getContentLength();

	/**
	 * The file-stream of the EntityBody content.
	 * @return resource stream
	 */
	public function getContentStream();

}
