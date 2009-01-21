<?php

class Phool_HeaderCaseNormalizerTest extends PhoolTestCase
{
	private $_normalizer;

	function setUp()
	{
		$this->_normalizer = new Phool_Header_HeaderCaseNormalizer();
	}

	public function testNormalizeOneWord()
	{
		$this->assertEqual(
			$this->_normalizer->normalize('test'),
			'Test'
		);
	}

	public function testNormalizeTwoWords()
	{
		$this->assertEqual(
			$this->_normalizer->normalize('test-header'),
			'Test-Header'
		);
	}

	public function testNormalizeManyWords()
	{
		$this->assertEqual(
			$this->_normalizer->normalize('one-Two-three-Four-five'),
			'One-Two-Three-Four-Five'
		);
	}
}
