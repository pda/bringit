<?php

/**
 * Encapsulates an HTTP or HTTPS URL parsed from a string.
 *
 * @author Paul Annesley <paul@annesley.cc>
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class Bringit_Url
{
	private
		$_inputString,
		$_fragments;

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
	public function scheme()
	{
		if (!$this->hasScheme()) throw new Bringit_Exception(sprintf(
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
	public function host()
	{
		if (!$this->hasHost()) throw new Bringit_Exception(sprintf(
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
	public function hostWithPort()
	{
		if ($this->hasPort() && (!$this->hasDefaultPort() || !$this->isPortDefault()))
		{
			return $this->host() . ':' . $this->port();
		}
		else
		{
			return $this->host();
		}
	}

	/**
	 * Path component (after host, before query string delimiter '?')
	 * @return string
	 */
	public function path()
	{
		return empty($this->_fragments['path']) ?
			'/' : $this->_fragments['path'];
	}

	/**
	 * Query string (after query delimiter '?', before fragment delimiter '#')
	 * @return string
	 */
	public function queryString()
	{
		if (!$this->hasQueryString()) throw new Bringit_Exception(sprintf(
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
	public function fragmentString()
	{
		if (!$this->hasFragmentString()) throw new Bringit_Exception(sprintf(
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
	public function port()
	{
		return empty($this->_fragments['port']) ?
			$this->defaultPort() : $this->_fragments['port'];
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
	public function defaultPort()
	{
		if (!$this->hasDefaultPort()) throw new Bringit_Exception(sprintf(
			"No default port for URL '%s'",
			$this->_inputString
		));

		$scheme = $this->scheme();
		if ($scheme == 'http') return 80;
		elseif ($scheme == 'https') return 443;
		else throw new Bringit_Exception("No default port for scheme '$scheme'");
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
		return $this->port() == $this->defaultPort();
	}

	/**
	 * The URL components after the host.
	 * @return string
	 */
	public function hostRelativeUrl()
	{
		$url = $this->path();
		if ($this->hasQueryString()) $url .= '?' . $this->queryString();
		if ($this->hasFragmentString()) $url .= '#' . $this->fragmentString();
		return $url;
	}

	/**
	 * The URL components after the scheme
	 * @return string
	 */
	public function schemeRelativeUrl()
	{
		return sprintf(
			'//%s%s',
			$this->hostWithPort(),
			$this->hostRelativeUrl()
		);
	}

	/**
	 * The URL as a string.
	 * @return string
	 */
	public function __toString()
	{
		if ($this->hasScheme())
			return $this->scheme() . ':' . $this->schemeRelativeUrl();

		if ($this->hasHost())
			return $this->schemeRelativeUrl();

		return $this->hostRelativeUrl();
	}

}
