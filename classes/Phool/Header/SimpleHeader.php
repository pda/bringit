<?php

class Phool_Header_SimpleHeader
	implements Phool_Header
{

	private $_name;
	private $_value;

	/**
	 * @param string $name
	 * @param string $value
	 */
	public function __construct($name, $value)
	{
		$normalizer = new Phool_Header_HeaderNameCaseNormalizer();
		$this->_name = $normalizer->normalize($name);
		$this->_value = $value;
	}


	/* (non-phpdoc)
	 * @see Phool_Header::getName()
	 */
	public function getName()
	{
		return $this->_name;
	}

	/* (non-phpdoc)
	 * @see Phool_Header::getValue()
	 */
	public function getValue()
	{
		return $this->_value;
	}

	/* (non-phpdoc)
	 * @see Phool_Header::__toString()
	 */
	public function __toString()
	{
		return sprintf(
			'%s: %s%s',
			$this->getName(),
			$this->getValue(),
			self::CRLF
		);
	}

}