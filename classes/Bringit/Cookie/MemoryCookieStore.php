<?php

/**
 * A cookie store with no persistence beyond instance memory.
 */
class Bringit_Cookie_MemoryCookieStore
	implements Bringit_Cookie_CookieStore
{
	private $_cookies = array();

	/* (non-phpdoc)
	 * @see Bringit_Cookie_CookieStore::add
	 */
	public function add($cookie)
	{
		$this->_cookies []= $cookie;
	}

	/* (non-phpdoc)
	 * @see Bringit_Cookie_CookieStore::get
	 */
	public function get($url)
	{
		// TODO: rewrite this naive implementation
		$cookies = array();

		foreach ($this->_cookies as $cookie)
		{
			$attributes = $cookie->attributes();

			// redo this attributes mess.
			if (
				isset($attributes['domain']) && $attributes['domain'] == $url->host() &&
				// TODO: do proper path matching
				isset($attributes['path']) && $attributes['path'] == $url->path()
				// TODO: test port, scheme, etc
				)
				$cookies []= $cookie;
		}

		return $cookies;
	}
}
