<?php

class Bringit_RequestHeaderTest extends BringitTestCase
{
	public function testRequestHeader()
	{
		$header = new Bringit_Header_RequestHeader();

		$header->setHeaderValue('One', 'wrong');
		$header->setHeaderValue('One', 'I');

		$header->setHeaderValue('Two', 'also wrong');
		$header->addField(new Bringit_Header_HeaderField('Two', 'II'));

		$header->addField(new Bringit_Header_HeaderField('Three', 'III'));
		$header->remove('Three');

		$this->assertEqual($header->value('One'), 'I');
		$this->assertEqual($header->value('Two'), 'II');
		try
		{
			$header->value('Three');
			$this->fail('Bringit_Exception should be thrown');
		}
		catch (Bringit_Exception $e)
		{
			$this->pass('Bringit_Exception should be thrown');
		}

		$headers = $header->fields();
		$this->assertIsA($headers, 'array');
		$this->assertEqual(count($headers), 2);
	}

	public function testToString()
	{
		$header = new Bringit_Header_RequestHeader();
		$header['one'] = 'I';
		$header['two'] = 'II';

		$this->assertEqual(
			"$header",
			"One: I\r\nTwo: II\r\n\r\n"
		);
	}

	public function testRequestHeaderCountable()
	{
		$header = new Bringit_Header_RequestHeader();
		$this->assertEqual(count($header), 0);

		$header->setHeaderValue('One', 'wrong');
		$this->assertEqual(count($header), 1);

		$header->setHeaderValue('One', 'I');
		$this->assertEqual(count($header), 1);

		$header->setHeaderValue('Two', 'II');
		$this->assertEqual(count($header), 2);

		$header->remove('One');
		$this->assertEqual(count($header), 1);
	}

	public function testRequestHeaderArrayAccess()
	{
		$header = new Bringit_Header_RequestHeader();
		$header['One'] = 'wrong';
		$header['One'] = 'I';
		$header['Two'] = 'II';

		$header['Three'] = 'III';
		$this->assertTrue(isset($header['Three']));
		unset($header['Three']);
		$this->assertFalse(isset($header['Three']));

		$this->assertEqual(count($header), 2);
		$this->assertEqual($header['One'], 'I');
		$this->assertEqual($header['Two'], 'II');

		$count = 0;
		foreach ($header as $name => $value)
		{
			$count++;
			$this->assertTrue(in_array($name, array('One', 'Two')));
			$this->assertTrue(in_array($value, array('I', 'II')));
		}
		$this->assertEqual($count, 2);
	}
}
