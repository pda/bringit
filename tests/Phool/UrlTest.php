<?php

class Phool_UrlTest extends PhoolTestCase
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
    $url = new Phool_Url('http://example.org:80/path?a=b&c=d#fragment');
    $this->_assertExpectedValues($url);
    $this->assertEqual($url->getHostRelativeUrl(), '/path?a=b&c=d#fragment');
    $this->assertEqual($url->getSchemeRelativeUrl(), '//example.org/path?a=b&c=d#fragment');
  }

  public function testBriefHttpUrlUsage()
  {
    $url = new Phool_Url('http://example.org/');
    $this->assertEqual($url->getHostRelativeUrl(), '/');
    $this->assertEqual($url->getSchemeRelativeUrl(), '//example.org/');
  }

  public function testHasMethods()
  {
    $url = new Phool_Url('http://example.org/?query#fragment');
    $this->assertTrue($url->hasHost(), 'URL should have host');
    $this->assertTrue($url->hasScheme(), 'URL should have scheme');
    $this->assertTrue($url->hasQueryString(), 'URL should have query string');
    $this->assertTrue($url->hasFragmentString(), 'URL should have fragment string');
    $this->assertTrue($url->hasPort(), 'URL should have port');
    $this->assertTrue($url->hasDefaultPort(), 'URL should have default port');

    $url = new Phool_Url('/');
    $this->assertFalse($url->hasHost(), 'URL should not have host');
    $this->assertFalse($url->hasScheme(), 'URL should not have scheme');
    $this->assertFalse($url->hasQueryString(), 'URL should not have query string');
    $this->assertFalse($url->hasFragmentString(), 'URL should not have fragment string');
    $this->assertFalse($url->hasPort(), 'URL should not have port');
    $this->assertFalse($url->hasDefaultPort(), 'URL should not have default port');
  }

  public function testExceptionsThrown()
  {
    $url = new Phool_Url('/');

    try {
      $url->getScheme();
      $this->fail('getScheme() should throw exception');
    } catch (Phool_Exception $e) {
      $this->pass('getScheme() should throw exception');
    }

    try {
      $url->getHost();
      $this->fail('getHost() should throw exception');
    } catch (Phool_Exception $e) {
      $this->pass('getHost() should throw exception');
    }

  }

  public function testBasicHttpsUsage()
  {
    $this->_assertExpectedValues(
      new Phool_Url('https://example.org/path?a=b&c=d#fragment'),
      array('scheme' => 'https', 'port' => 443)
    );
  }

  public function testCustomPort()
  {
    // http
    $url = new Phool_Url('http://example.org:81/path?a=b&c=d#fragment');
    $this->_assertExpectedValues($url, array('port' => 81));

    // https
    $url = new Phool_Url('https://example.org:82/path?a=b&c=d#fragment');
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
      $url = new Phool_Url($urlString);
      $this->assertTrue($url->isPortDefault(),
        "port should be default in $urlString");
    }

    foreach ($customPortUrls as $urlString)
    {
      $url = new Phool_Url($urlString);
      $this->assertFalse($url->isPortDefault(),
        "port should not be default in $urlString");
    }

  }

  public function testWithoutPath()
  {
    $url = new Phool_Url('http://example.org');
    $this->assertEqual($url->getPath(), '/');
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

      $url = new Phool_Url($in);
      $this->assertEqual("$url", $expect,
        "For input [$in] %s");
    }
  }

  // ----------------------------------------

  private function _assertExpectedValues($url, $custom = array())
  {
    $expected = array_merge($this->_sampleData, $custom);

    $this->assertEqual($url->getScheme(), $expected['scheme']);
    $this->assertEqual($url->getHost(), $expected['host']);
    $this->assertEqual($url->getPath(), $expected['path']);
    $this->assertEqual($url->getQueryString(), $expected['querystring']);
    $this->assertEqual($url->getFragmentString(), $expected['fragment']);
    $this->assertEqual($url->getPort(), $expected['port']);
  }

}
