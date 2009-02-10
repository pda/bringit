<?php

class Phool_CookieStoreTest extends UnitTestCase
{
	public function testBasicUsage()
	{
		$store = new Phool_Cookie_MemoryCookieStore();

		$cookie = new Phool_Cookie_Cookie('name1', 'value1', array(
			'domain' => '.example.org',
			'path' => '/test',
		));

		$store->add(new Phool_Url('http://www.example.com/test'), $cookie);

		// domain mismatch
		$url = new Phool_Url('http://example.com/test');
		$cookies = $store->get($url);
		$this->assertEqual(count($cookies), 0, '%s: should be domain mismatch');

		// path mismatch
		$url = new Phool_Url('http://example.org/wrong');
		$cookies = $store->get($url);
		$this->assertEqual(count($cookies), 0, '%s: should be path mismatch');

		// exact path
		$url = new Phool_Url('http://example.org/test');
		$cookies = $store->get($url);
		$this->assertEqual(count($cookies), 1);

		// valid sub-path
		$url = new Phool_Url('http://example.org/test/1');
		$cookies = $store->get($url);
		$this->assertEqual(count($cookies), 1);

		// valid subdomain
		$url = new Phool_Url('http://subdomain.example.org/test');
		$cookies = $store->get($url);
		$this->assertEqual(count($cookies), 1);

		$cookie = $cookies[0];

		$this->assertEqual($cookie->name(), 'name1');
		$this->assertEqual($cookie->value(), 'value1');
	}
}
