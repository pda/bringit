<?php

class Phool_DnsResolverTest extends UnitTestCase
{
	public function testGetHostByName()
	{
		$resolver = new Phool_DnsResolver();
		$this->assertEqual(
			$resolver->hostByName('localhost'),
			'127.0.0.1'
		);
	}

	public function testGetHostsByName()
	{
		$resolver = new Phool_DnsResolver();
		$this->assertEqual(
			$resolver->hostsByName('localhost'),
			array('127.0.0.1')
		);
	}
}
