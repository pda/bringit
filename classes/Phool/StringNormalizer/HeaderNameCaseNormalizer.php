<?php

/**
 * Normalizes the capitalization of HTTP header names e.g. Content-Type.
 */
class Phool_StringNormalizer_HeaderNameCaseNormalizer
	implements Phool_StringNormalizer
{

	public function normalize($string)
	{
		return preg_replace_callback('#\w+#', array($this, '_callback'), $string);
	}

	/**
	 * Callback for preg_replace in self::normalize()
	 */
	private function _callback($matches)
	{
		return ucwords($matches[0]);
	}

}