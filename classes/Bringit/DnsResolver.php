<?php

/**
 * Uses DNS to resolves hostnames to IP addresses.
 */
class Bringit_DnsResolver
{
	/**
	 * Resolves a hostname to one or more IP addresses.
	 * @param string $hostname
	 * @return array
	 * @throw Bringit_Exception_DnsError
	 */
	public function hostsByName($hostname)
	{
		if (!$hosts = gethostbynamel($hostname))
			throw new Bringit_Exception_DnsException(
				"Unable to resolve hostname '$hostname'");

		return $hosts;
	}

	/**
	 * Resolves a hostname to a single IP address.
	 * @param string $hostname
	 * @return string
	 * @throw Bringit_Exception_DnsError
	 */
	public function hostByName($hostname)
	{
		if (!$host = gethostbyname($hostname))
			throw new Bringit_Exception_DnsException(
				"Unable to resolve hostname '$hostname'");

		return $host;
	}

}
