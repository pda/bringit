<?php

/**
 * An HTTP request.
 * @see http://tools.ietf.org/html/rfc2616#section-5
 */
interface Phool_Request
{

	const METHOD_OPTIONS = 'OPTIONS';
	const METHOD_GET = 'GET';
	const METHOD_HEAD = 'HEAD';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';
	const METHOD_TRACE = 'TRACE';
	const METHOD_CONNECT = 'CONNECT';

	/**
	 * The method of the request.
	 * @see http://tools.ietf.org/html/rfc2616#section-5.1.1
	 * @return Phool_RequestMethod
	 */
	public function getRequestMethod();

	/**
	 * The URL addressing the resource to request.
	 * @return Phool_Url
	 */
	public function getUrl();

	/**
	 * @return Phool_Header_HeaderCollection
	 */
	public function getHeaderCollection();

	/**
	 * Whether the request has an Entity Body.
	 * @see http://tools.ietf.org/html/rfc2616#section-7.2
	 * @return bool
	 */
	public function hasEntityBody();

	/**
	 * The Entity Body of the Request.
	 * @see http://tools.ietf.org/html/rfc2616#section-7.2
	 * @return Phool_EntityBody
	 */
	public function getEntityBody();

}