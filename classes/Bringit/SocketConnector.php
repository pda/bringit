<?php

/**
 * A connector which uses raw sockets
 */
class Bringit_SocketConnector
{
	const SOCKET_TIMEOUT_OPEN = 20;
	const FREAD_CHUNKSIZE = 1024;

	private $_ipAddress;

	/**
	 * @param string $ipAddress The IP address to connect to.
	 */
	public function __construct($ipAddress)
	{
		$this->_ipAddress = $ipAddress;
	}

	public function handleRequest($request)
	{
		$url = $request->url();

		$socket = fsockopen(
			$this->_ipAddress,
			$url->port(),
			$errno,
			$errstr,
			self::SOCKET_TIMEOUT_OPEN
		);

		if (!$socket)
		{
			throw new Bringit_Exception_ConnectionException(sprintf(
				"Unable to open socket to %s:%d for %s (%d: %s)",
				$this->_ipAddress,
				$url->port(),
				$url,
				$errno,
				$errstr
			));
		}

		// write request line to socket
		fwrite(
			$socket,
			$request->requestLine()->__toString()
		);

		// write headers to socket
		fwrite(
			$socket,
			$request->header()->__toString()
		);

		if ($request->hasEntityBody())
		{
			$bodyStream = $request->entityBody()->contentStream();

			while (!feof($bodyStream))
			{
				fwrite(
					$socket,
					fread($bodyStream, self::FREAD_CHUNKSIZE)
				);
			}
		}

		$parser = new Bringit_Header_ResponseHeaderParser();
		$responseHeader = $parser->parseStream($socket);

		$entityBodyFactory = new Bringit_EntityBodyFactory();
		$entityBody = $entityBodyFactory->createFromStream($socket);

		return new Bringit_Response($request, $responseHeader, $entityBody);
	}

}
