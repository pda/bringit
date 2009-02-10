<?php

/**
 * Stores and retreives cookies.
 */
interface Phool_Cookie_CookieStore
{
	/**
	 * Sets a cookie in the store, subject to expiry etc.
	 * @param Phool_Cookie_Cookie
	 * @chainable
	 */
	public function add($cookie);

	/**
	 * Gets stored cookies that validly match the given URL.
	 * @param Phool_Url
	 */
	public function get($url);
}
