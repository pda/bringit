<?php

/**
 * Encapsulates an HTTP or HTTPS URL parsed from a string.
 */
class Phool_Url
{

	private $_inputString;
	private $_fragments;

	/**
	 * @param string $urlString
	 */
	public function __construct($urlString)
	{
		$this->_inputString = $urlString;

		if (preg_match('#^//#', $urlString))
		{
			// parse_url treats scheme-relative URLs as path-only...
			$this->_fragments = @parse_url("scheme:$urlString");
			unset($this->_fragments['scheme']);
		}
		else
		{
			$this->_fragments = @parse_url($urlString);
		}
	}

	/**
	 * Scheme, either http or https
	 * @return string
	 */
	public function getScheme()
	{
		if (!$this->hasScheme()) throw new Phool_Exception(sprintf(
			"URL '%s' has no scheme component",
			$this->_inputString
		));

		return $this->_fragments['scheme'];
	}

	/**
	 * Whether the URL has a scheme component.
	 * @return bool
	 */
	public function hasScheme()
	{
		return !empty($this->_fragments['scheme']);
	}

	/**
	 * Hostname (without port information) e.g. example.org
	 * @return string
	 */
	public function getHost()
	{
		if (!$this->hasHost()) throw new Phool_Exception(sprintf(
			"URL '%s' has no host component",
			$this->_inputString
		));

		return $this->_fragments['host'];
	}

	/**
	 * Whether the URL has a host component.
	 * @return bool
	 */
	public function hasHost()
	{
		return !empty($this->_fragments['host']);
	}

	/**
	 * Host, including port unless it is the default port for the scheme.
	 * @return string
	 */
	public function getHostWithPort()
	{
		if ($this->hasPort() && (!$this->hasDefaultPort() || !$this->isPortDefault()))
		{
			return $this->getHost() . ':' . $this->getPort();
		}
		else
		{
			return $this->getHost();
		}
	}

	/**
	 * Path component (after host, before query string delimiter '?')
	 * @return string
	 */
	public function getPath()
	{
		return empty($this->_fragments['path']) ?
			'/' : $this->_fragments['path'];
	}

	/**
	 * Query string (after query delimiter '?', before fragment delimiter '#')
	 * @return string
	 */
	public function getQueryString()
	{
		if (!$this->hasQueryString()) throw new Phool_Exception(sprintf(
			"URL '%s' has no query string",
			$this->_inputString
		));

		return $this->_fragments['query'];
	}

	/**
	 * Whether the URL has a query string.
	 * @return bool
	 */
	public function hasQueryString()
	{
		return !empty($this->_fragments['query']);
	}

	/**
	 * Fragment string (after fragment delimiter '#')
	 * @return string
	 */
	public function getFragmentString()
	{
		if (!$this->hasFragmentString()) throw new Phool_Exception(sprintf(
			"URL '%s' has no fragment string",
			$this->_inputString
		));

		return $this->_fragments['fragment'];
	}

	/**
	 * Whether the URL has a fragment string.
	 * @return bool
	 */
	public function hasFragmentString()
	{
		return !empty($this->_fragments['fragment']);
	}

	/**
	 * TCP port number, defaults to 80 for HTTP and 443 for HTTPS.
	 * @return int
	 */
	public function getPort()
	{
		return empty($this->_fragments['port']) ?
			$this->getDefaultPort() : $this->_fragments['port'];
	}

	/**
	 * Whether the URL has an explicitly specified port.
	 */
	public function hasPort()
	{
		return isset($this->_fragments['port']) || $this->hasDefaultPort();
	}

	/**
	 * The default TCP port for the scheme of the URL
	 * @return int or null
	 */
	public function getDefaultPort()
	{
		if (!$this->hasDefaultPort()) throw new Phool_Exception(sprintf(
			"No default port for URL '%s'",
			$this->_inputString
		));

		$scheme = $this->getScheme();
		if ($scheme == 'http') return 80;
		elseif ($scheme == 'https') return 443;
		else throw new Phool_Exception("No default port for scheme '$scheme'");
	}

	/**
	 * Whether the URL has a default port (i.e. has a scheme)
	 */
	public function hasDefaultPort()
	{
		return $this->hasScheme();
	}

	/**
	 * Whether the port is the default for the scheme.
	 * @return bool
	 */
	public function isPortDefault()
	{
		return $this->getPort() == $this->getDefaultPort();
	}

	/**
	 * The URL components after the host.
	 * @return string
	 */
	public function getHostRelativeUrl()
	{
		$url = $this->getPath();
		if ($this->hasQueryString()) $url .= '?' . $this->getQueryString();
		if ($this->hasFragmentString()) $url .= '#' . $this->getFragmentString();
		return $url;
	}

	/**
	 * The URL components after the scheme
	 * @return string
	 */
	public function getSchemeRelativeUrl()
	{
		return sprintf(
			'//%s%s',
			$this->getHostWithPort(),
			$this->getHostRelativeUrl()
		);
	}

	/**
	 * The URL as a string.
	 * @return string
	 */
	public function __toString()
	{
		if ($this->hasScheme())
			return $this->getScheme() . ':' . $this->getSchemeRelativeUrl();

		if ($this->hasHost())
			return $this->getSchemeRelativeUrl();

		return $this->getHostRelativeUrl();
	}

}