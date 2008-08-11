<?php

/**
 * A connector which uses raw sockets
 */
class Phool_SocketConnector
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
		$url = $request->getUrl();

		$socket = fsockopen(
			$this->_ipAddress,
			$url->getPort(),
			$errno,
			$errstr,
			self::SOCKET_TIMEOUT_OPEN
		);

		if (!$socket)
		{
			throw new Phool_Exception_ConnectionException(sprintf(
				"Unable to open socket to %s:%d for %s (%d: %s)",
				$this->_ipAddress,
				$url->getPort(),
				$url,
				$errno,
				$errstr
			));
		}

		// write request line to socket
		fwrite(
			$socket,
			$request->getRequestLine()->__toString()
		);

		// write headers to socket
		fwrite(
			$socket,
			$request->getHeader()->__toString()
		);

		if ($request->hasEntityBody())
		{
			$bodyStream = $request->getEntityBody()->getContentStream();

			while (!feof($bodyStream))
			{
				fwrite(
					$socket,
					fread($bodyStream, self::FREAD_CHUNKSIZE)
				);
			}
		}

		$parser = new Phool_Header_ResponseHeaderParser();
		$responseHeader = $parser->parseStream($socket);

		$entityBodyFactory = new Phool_Body_EntityBodyFactory();
		$entityBody = $entityBodyFactory->createFromStream($socket);

		return new Phool_Response($request, $responseHeader, $entityBody);
	}

}
