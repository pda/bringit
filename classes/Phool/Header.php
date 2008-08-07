<?php

/**
 * Header belonging to an HTTP request or response.
 */
interface Phool_Header
{

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

}
