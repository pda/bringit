<?php

class Phool_RequestHeaderCollectionTest extends PhoolTestCase
{

	public function testRequestHeaderCollection()
	{
		$collection = new Phool_Header_RequestHeaderCollection();

		$collection->setHeaderValue('One', 'wrong');
		$collection->setHeaderValue('One', 'I');

		$collection->setHeaderValue('Two', 'also wrong');
		$collection->addHeader(new Phool_Header_SimpleHeader('Two', 'II'));

		$collection->addHeader(new Phool_Header_SimpleHeader('Three', 'III'));
		$collection->removeHeader('Three');

		$this->assertEqual($collection->getHeaderValue('One'), 'I');
		$this->assertEqual($collection->getHeaderValue('Two'), 'II');
		try
		{
			$collection->getHeaderValue('Three');
			$this->fail('Phool_Exception should be thrown');
		}
		catch (Phool_Exception $e)
		{
			$this->pass('Phool_Exception should be thrown');
		}

		$headers = $collection->getHeaders();
		$this->assertIsA($headers, 'array');
		$this->assertEqual(count($headers), 2);
	}

	public function testToString()
	{
		$collection = new Phool_Header_RequestHeaderCollection();
		$collection['one'] = 'I';
		$collection['two'] = 'II';

		$this->assertEqual(
			"$collection",
			"One: I\r\nTwo: II\r\n"
		);
	}

	public function testRequestHeaderCollectionCountable()
	{
		$collection = new Phool_Header_RequestHeaderCollection();
		$this->assertEqual(count($collection), 0);

		$collection->setHeaderValue('One', 'wrong');
		$this->assertEqual(count($collection), 1);

		$collection->setHeaderValue('One', 'I');
		$this->assertEqual(count($collection), 1);

		$collection->setHeaderValue('Two', 'II');
		$this->assertEqual(count($collection), 2);

		$collection->removeHeader('One');
		$this->assertEqual(count($collection), 1);
	}

	public function testRequestHeaderCollectionArrayAccess()
	{
		$collection = new Phool_Header_RequestHeaderCollection();
		$collection['One'] = 'wrong';
		$collection['One'] = 'I';
		$collection['Two'] = 'II';

		$collection['Three'] = 'III';
		$this->assertTrue(isset($collection['Three']));
		unset($collection['Three']);
		$this->assertFalse(isset($collection['Three']));

		$this->assertEqual(count($collection), 2);
		$this->assertEqual($collection['One'], 'I');
		$this->assertEqual($collection['Two'], 'II');

		$count = 0;
		foreach ($collection as $name => $value)
		{
			$count++;
			$this->assertTrue(in_array($name, array('One', 'Two')));
			$this->assertTrue(in_array($value, array('I', 'II')));
		}
		$this->assertEqual($count, 2);
	}

}
