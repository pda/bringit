<?php

/**
 * Normalizes strings to a single, implementation-defined format.
 */
interface Phool_StringNormalizer
{

	/**
	 * Normalize a given string.
	 * @param string $string
	 * @return string
	 */
	public function normalize($string);

}