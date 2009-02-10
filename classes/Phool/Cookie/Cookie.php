<?php

/**
 * An HTTP cookie.
 */
class Phool_Cookie_Cookie
{
	private
		$_name,
		$_value,
		$_domain,
		$_path;

	/**
	 * @param string $name
	 * @param string $value
	 * @param array $attributes
	 */
	public function __construct($name, $value, $domain, $path)
	{
		$this->_name = $name;
		$this->_value = $value;
		$this->_domain = $domain;
		$this->_path = $path;
	}

	/**
	 * The cookie name.
	 * @return string
	 */
	public function name()
	{
		return $this->_name;
	}

	/**
	 * The cookie value.
	 * @return string
	 */
	public function value()
	{
		return $this->_value;
	}

	/**
	 * The domain the cookie is set agaist.
	 * @return string
	 */
	public function domain()
	{
		return $this->_domain;
	}

	/**
	 * The path the cookie is set against.
	 * @return string
	 */
	public function path()
	{
		return $this->_path;
	}
}
