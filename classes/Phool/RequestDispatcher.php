<?php

class Phool_RequestDispatcher
{

	/**
	 * @param Phool_Request
	 * @return Phool_Response
	 */
	public function dispatch($request)
	{
		$url = $request->getUrl();
		$dnsResolver = new Phool_DnsResolver();
		$failCount = 0;
		$exceptions = array();

		foreach ($dnsResolver->getHostsByName($url->getHost()) as $ipAddress)
		{
			try
			{
				$connector = new Phool_SocketConnector($ipAddress);
				return $connector->handleRequest($request);
			}
			catch (Phool_Exception_ConnectionException $e)
			{
				$failCount++;
				$exceptions []= $e;
			}
		}

		// TODO: better failure handling
		throw new Phool_Exception_ConnectionException(sprintf(
			'%d connection failures: %s',
			$failCount,
			implode(', ', $exceptions)
		));
	}

}
