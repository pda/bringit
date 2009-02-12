<?php

/**
 * Normalizes the capitalization of HTTP header names e.g. Content-Type.
 */
class Bringit_Header_HeaderCaseNormalizer
{
	/**
	 * @param string $string
	 * @return string
	 */
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
