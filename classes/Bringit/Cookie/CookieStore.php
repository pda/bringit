<?php

/**
 * Stores and retreives cookies.
 */
interface Bringit_Cookie_CookieStore
{
	/**
	 * Sets a cookie in the store, subject to expiry etc.
	 * @param Bringit_Cookie_Cookie
	 * @chainable
	 */
	public function add($cookie);

	/**
	 * Gets stored cookies that validly match the given URL.
	 * @param Bringit_Url
	 */
	public function get($url);
}
