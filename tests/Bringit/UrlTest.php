<?php

class Bringit_UrlTest extends BringitTestCase
{
	private $_sampleData = array(
		'scheme' => 'http',
		'host' => 'example.org',
		'path' => '/path',
		'querystring' => 'a=b&c=d',
		'fragment' => 'fragment',
		'port' => 80,
	);

	public function testVerboseHttpUrlUsage()
	{
		$url = new Bringit_Url('http://example.org:80/path?a=b&c=d#fragment');
		$this->_assertExpectedValues($url);
		$this->assertEqual($url->hostRelativeUrl(), '/path?a=b&c=d#fragment');
		$this->assertEqual($url->schemeRelativeUrl(), '//example.org/path?a=b&c=d#fragment');
	}

	public function testBriefHttpUrlUsage()
	{
		$url = new Bringit_Url('http://example.org/');
		$this->assertEqual($url->hostRelativeUrl(), '/');
		$this->assertEqual($url->schemeRelativeUrl(), '//example.org/');
	}

	public function testHasMethods()
	{
		$url = new Bringit_Url('http://example.org/?query#fragment');
		$this->assertTrue($url->hasHost(), 'URL should have host');
		$this->assertTrue($url->hasScheme(), 'URL should have scheme');
		$this->assertTrue($url->hasQueryString(), 'URL should have query string');
		$this->assertTrue($url->hasFragmentString(), 'URL should have fragment string');
		$this->assertTrue($url->hasPort(), 'URL should have port');
		$this->assertTrue($url->hasDefaultPort(), 'URL should have default port');

		$url = new Bringit_Url('/');
		$this->assertFalse($url->hasHost(), 'URL should not have host');
		$this->assertFalse($url->hasScheme(), 'URL should not have scheme');
		$this->assertFalse($url->hasQueryString(), 'URL should not have query string');
		$this->assertFalse($url->hasFragmentString(), 'URL should not have fragment string');
		$this->assertFalse($url->hasPort(), 'URL should not have port');
		$this->assertFalse($url->hasDefaultPort(), 'URL should not have default port');
	}

	public function testExceptionsThrown()
	{
		$url = new Bringit_Url('/');

		try {
			$url->scheme();
			$this->fail('scheme() should throw exception');
		} catch (Bringit_Exception $e) {
			$this->pass('scheme() should throw exception');
		}

		try {
			$url->host();
			$this->fail('host() should throw exception');
		} catch (Bringit_Exception $e) {
			$this->pass('host() should throw exception');
		}

	}

	public function testBasicHttpsUsage()
	{
		$this->_assertExpectedValues(
			new Bringit_Url('https://example.org/path?a=b&c=d#fragment'),
			array('scheme' => 'https', 'port' => 443)
		);
	}

	public function testCustomPort()
	{
		// http
		$url = new Bringit_Url('http://example.org:81/path?a=b&c=d#fragment');
		$this->_assertExpectedValues($url, array('port' => 81));

		// https
		$url = new Bringit_Url('https://example.org:82/path?a=b&c=d#fragment');
		$this->_assertExpectedValues($url, array('port' => 82, 'scheme' => 'https'));
	}

	public function testIsDefaultPort()
	{
		$defaultPortUrls = array(
			'http://example.org/',
			'http://example.org:80/',
			'https://example.org/',
			'https://example.org:443/',
		);

		$customPortUrls = array(
			'http://example.org:443/',
			'https://example.org:80/',
			'http://example.org:8080/',
			'https://example.org:8090/',
		);

		foreach ($defaultPortUrls as $urlString)
		{
			$url = new Bringit_Url($urlString);
			$this->assertTrue($url->isPortDefault(),
				"port should be default in $urlString");
		}

		foreach ($customPortUrls as $urlString)
		{
			$url = new Bringit_Url($urlString);
			$this->assertFalse($url->isPortDefault(),
				"port should not be default in $urlString");
		}

	}

	public function testWithoutPath()
	{
		$url = new Bringit_Url('http://example.org');
		$this->assertEqual($url->path(), '/');
	}

	public function testSerializeToString()
	{
		// single element means expect in = out
		$pairs = array(

			// host-relative
			array('/'),
			array('/path'),
			array('/path/'),
			array('/path?', '/path'),
			array('/path/?', '/path/'),
			array('/path?query'),
			array('/path?query#', '/path?query'),
			array('/path?query#frag'),

			// scheme-relative
			array('//example.org', '//example.org/'),
			array('//example.org:80', '//example.org:80/'),
			array('//example.org:81', '//example.org:81/'),
			array('//example.org/'),
			array('//example.org:80/'),
			array('//example.org:81/'),
			array('//example.org/path'),
			array('//example.org/path?query'),
			array('//example.org/path?query#frag'),

			// absolute
			array('http://example.org/'),
			array('https://example.org/'),
			array('http://example.org:8000/'),
			array('https://example.org:8000/'),
			array('http://example.org:443/'),
			array('https://example.org:80/'),
			array('http://example.org:80/', 'http://example.org/'),
			array('https://example.org:443/', 'https://example.org/'),
			array('http://example.org/path?query#fragment'),
		);

		foreach ($pairs as $pair)
		{
			$in = $pair[0];
			$expect = isset($pair[1]) ? $pair[1] : $pair[0];

			$url = new Bringit_Url($in);
			$this->assertEqual("$url", $expect,
				"For input [$in] %s");
		}
	}

	// ----------------------------------------

	private function _assertExpectedValues($url, $custom = array())
	{
		$expected = array_merge($this->_sampleData, $custom);

		$this->assertEqual($url->scheme(), $expected['scheme']);
		$this->assertEqual($url->host(), $expected['host']);
		$this->assertEqual($url->path(), $expected['path']);
		$this->assertEqual($url->queryString(), $expected['querystring']);
		$this->assertEqual($url->fragmentString(), $expected['fragment']);
		$this->assertEqual($url->port(), $expected['port']);
	}
}
