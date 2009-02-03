<?php

/**
 * A collection of header fields belonging to an HTTP request.
 * Header names/keys are case insensitive and unique.
 * Provides ArrayAccess for header name/value pairs.
 */
class Phool_Header_RequestHeader
	extends ArrayIterator
{
	private $_fields = array();

	/**
	 * @return Phool_Header[]
	 */
	public function fields()
	{
		return $this->_fields;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		$serializer = new Phool_Header_RequestHeaderSerializer($this);
		return $serializer->serialize();
	}

	/**
	 * Adds a header field, overwriting any existing field of the same name.
	 * @param Phool_Header
	 */
	public function addField($field)
	{
		$this[$field->name()] = $field;
	}

	/**
	 * Adds or overwrites a header in the  with a new header.
	 * The header name is normalized and thus case insensitive.
	 * @param string $name
	 * @param string $value
	 */
	public function setHeaderValue($name, $value)
	{
		$this[$name] = $value;
	}

	/**
	 * @param string $name
	 * @return Phool_Header_HeaderField
	 * @throws Phool_Exception if named header does not exist.
	 */
	public function field($name)
	{
		if (!isset($this[$name]))
			throw new Phool_Exception("Header '$name' not set");

		return $this->_fields[$name];
	}

	/**
	 * Gets the value of the header with the given name,
	 * The header name is normalized and thus case insensitive.
	 * @param string $name
	 * @throws Phool_Exception if named header does not exist.
	 */
	public function value($name)
	{
		return $this[$name];
	}

	/**
	 * Removes the header of the given name if it exists.
	 * @param string $name
	 */
	public function remove($name)
	{
		unset($this[$name]);
	}

	// ----------------------------------------

	public function offsetExists($offset)
	{
		$name = $this->_normalizeHeaderName($offset);
		return parent::offsetExists($name);
	}

	public function offsetGet($offset)
	{
		$name = $this->_normalizeHeaderName($offset);

		if (!parent::offsetExists($name)) throw new Phool_Exception(
			"Header '$name' not in "
		);

		return parent::offsetGet($name);
	}

	public function offsetSet($offset, $newval)
	{
		$name = $this->_normalizeHeaderName($offset);
		$header = is_object($newval) ?
			$newval : new Phool_Header_HeaderField($name, $newval);
		$value = $header->value();

		$this->_fields[$name] = $header;
		parent::offsetSet($name, $value);
	}

	public function offsetUnset($offset)
	{
		$name = $this->_normalizeHeaderName($offset);
		unset($this->_fields[$name]);
		parent::offsetUnset($name);
	}

	// ----------------------------------------

	/**
	 * @param string
	 * @return string
	 */
	private function _normalizeHeaderName($name)
	{
		$normalizer = new Phool_Header_HeaderCaseNormalizer();
		return $normalizer->normalize($name);
	}
}