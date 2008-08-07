<?php

/**
 * A collection of headers belonging to an HTTP request.
 * Header names/keys are case insensitive and non-unique in the collection.
 */
class Phool_Header_RequestHeaderCollection
{

	public function addHeader($name, $value)
	{
		throw BadMethodCallException(__METHOD__ . ' not implemented');
	}

}