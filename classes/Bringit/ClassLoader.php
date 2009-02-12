<?php

/**
 * SPL class loader for Bringit.
 */
class Bringit_ClassLoader
{
	/**
	 * Registers this class as an SPL class loader.
	 */
	public static function register()
	{
		spl_autoload_register(array(__CLASS__, 'loadClass'));
	}

	/**
	 * SPL autoload function, loads a Bringit class file based on the class name.
	 *
	 * @param string
	 */
	public static function loadClass($className)
	{
		if (preg_match('#^Bringit#', $className))
		{
			require_once(preg_replace('#_#', '/', $className).'.php');
		}
	}

	/**
	 * Prepends one or more path to the PHP include path
	 * @param mixed $items Path or paths as string or array
	 */
	public static function addIncludePath($items)
	{
		$elements = explode(PATH_SEPARATOR, get_include_path());

		if (is_array($items))
		{
			set_include_path(implode(PATH_SEPARATOR, array_merge($items, $elements)));
		}
		else
		{
			array_unshift($elements, $items);
			set_include_path(implode(PATH_SEPARATOR, $elements));
		}
	}

}
