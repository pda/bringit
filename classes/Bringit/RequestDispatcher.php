<?php

class Bringit_RequestDispatcher
{
	/**
	 * @param Bringit_Request
	 * @return Bringit_Response
	 */
	public function dispatch($request)
	{
		$url = $request->url();
		$dnsResolver = new Bringit_DnsResolver();
		$failCount = 0;
		$exceptions = array();

		foreach ($dnsResolver->hostsByName($url->host()) as $ipAddress)
		{
			try
			{
				$connector = new Bringit_SocketConnector($ipAddress);
				return $connector->handleRequest($request);
			}
			catch (Bringit_Exception_ConnectionException $e)
			{
				$failCount++;
				$exceptions []= $e;
			}
		}

		// TODO: better failure handling
		throw new Bringit_Exception_ConnectionException(sprintf(
			'%d connection failures: %s',
			$failCount,
			implode(', ', $exceptions)
		));
	}

}
