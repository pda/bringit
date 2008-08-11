<?php

/**
 * Accepts HTTP requests, sends full raw request as text/plain response.
 * @author Paul Annesley <paul@annesley.cc>
 */

error_reporting(E_ALL);
ini_set('display_errors', true);

define('LISTEN_URI', 'tcp://0.0.0.0:10080');

if (!$socket = stream_socket_server(LISTEN_URI, $errno, $errstr))
	die("$errstr ($errno)\n");

echo "Listening for HTTP requests on " . LISTEN_URI . "\n";

while (true)
{
	if ($conn = stream_socket_accept($socket, -1, $peername))
	{
		echo "\nAccepted connection from $peername\n";

		$data = fgets($conn);
		printf("  %s\n", trim($data));

		// read headers
		while (($data .= fread($conn, 1)) !== false && substr($data, -4, 4) !== "\r\n\r\n");

		// read body up to content-length if specified
		if (preg_match('#\r\nContent-Length: (\d+)\r\n#i', $data, $matches))
		{
			printf("  Expecting %d byte body\n", $matches[1]);

			for ($i = 0; $i < $matches[1]; $i++)
				if (($char = fread($conn, 1)) !== false)
					$data .= $char;
		}

		$requestDataLength = strlen($data);
		printf("  Reflecting %d bytes of raw request data... ", $requestDataLength);

		// write response, using the entire raw request as the response body
		fwrite($conn,
			"HTTP/1.0 200 OK\r\n".
			"Content-Type: text/plain\r\n".
			"Content-Length: $requestDataLength\r\n".
			"\r\n".
			$data
		);

		fclose($conn);
		echo "done\n";
	}
}

fclose($socket);
