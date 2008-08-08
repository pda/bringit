<?php

/**
 * An collection of HTTP headers belonging to a Request or a Response.
 */
interface Phool_Header_HeaderCollection
{

	/**
	 * Array of Phool_Header instances contained in the collection.
	 * @return Phool_Header[]
	 */
	public function getHeaders();

	/**
	 * The serialized collection of headers.
	 * @return string
	 */
	public function __toString();

}
