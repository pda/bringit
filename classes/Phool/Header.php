<?php

/**
 * An HTTP header belonging to a Request or a Response.
 *
 * Specifically, one of:
 *   General Header {@link http://tools.ietf.org/html/rfc2616#section-4.5}
 *   Request Header {@link http://tools.ietf.org/html/rfc2616#section-5.3}
 *   Response Header {@link http://tools.ietf.org/html/rfc2616#section-6.2}
 *   Entity Header {http://tools.ietf.org/html/rfc2616#section-7.1}
 *
 * All follow the general format given in Section 3.1 of RFC 822.
 * {@link http://tools.ietf.org/html/rfc822#section-3.1}
 */
interface Phool_Header
{

	const CRLF = "\r\n";

	/**
	 * The case-normalized name of the header.
	 * @return string
	 */
	public function getName();

	/**
	 * The value of the header.
	 * @return string
	 */
	public function getValue();

	/**
	 * The full header string, e.g. 'Example-Header: Some Value'
	 * @return string
	 */
	public function __toString();

}
