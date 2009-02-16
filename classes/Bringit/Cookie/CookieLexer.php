<?php

/**
 * Lexical analyzer for Set-Cookie and Set-Cookie2 HTTP headers.
 * Should be refactored to use a generic lexer implementation.
 * Currently uses non-stack-tracked lexical state transitions.
 */
class Bringit_Cookie_CookieLexer
{
	// tokens
	const T_WHITESPACE = 'whitespace';
	const T_NAME = 'name';
	const T_EQUALS = 'equals';
	const T_DOUBLEQUOTE = 'doublequote';
	const T_VALUE = 'value';
	const T_SEMICOLON = 'semicolon';
	const T_COMMA = 'comma';

	// states
	const STATE_ROOT = 'root';
	const STATE_ASSIGNMENT = 'assignment';
	const STATE_DOUBLEQUOTEDVALUE = 'doublequotedvalue';

	private $_stateTokens = array(
		// root state, expects a name
		self::STATE_ROOT => array(
			self::T_WHITESPACE => '\s+',
			self::T_NAME => '[$\w]\w*',
			self::T_EQUALS => '=',
		),
		// state which expects a value
		self::STATE_ASSIGNMENT => array(
			self::T_WHITESPACE => '\s+',
			self::T_SEMICOLON => ';',
			self::T_COMMA => ',',
			self::T_DOUBLEQUOTE => '"',
			self::T_VALUE => '[^\s;]+',
		),
		// state within double-quoted string
		self::STATE_DOUBLEQUOTEDVALUE => array(
			self::T_VALUE => '(?:(?:\\\")?[^"](?:\\\")?)+',
			self::T_DOUBLEQUOTE => '(?<!\\\)"',
		),
	);

	private $_stateTransitions = array(
		self::STATE_ROOT => array(
			self::T_EQUALS => self::STATE_ASSIGNMENT,
		),
		self::STATE_DOUBLEQUOTEDVALUE => array(
			self::T_DOUBLEQUOTE => self::STATE_ASSIGNMENT,
		),
		self::STATE_ASSIGNMENT => array(
			self::T_DOUBLEQUOTE => self::STATE_DOUBLEQUOTEDVALUE,
			self::T_SEMICOLON => self::STATE_ROOT,
			self::T_COMMA => self::STATE_ROOT,
		),
	);

	private
		$_state = self::STATE_ROOT,
		$_input;

	/**
	 * @param string
	 */
	public function __construct($string)
	{
		$this->_input = $string;
	}

	/**
	 * The next token of a Set-Cookie or Set-Cookie2 header.
	 * @param string
	 * @return array
	 */
	public function next()
	{
		if (strlen($this->_input) == 0) return false;

		foreach ($this->_stateTokens() as $token => $reBody)
		{
			$re = "#^{$reBody}#";

			if (preg_match($re, $this->_input, $matches))
			{
				$match = $matches[0];
				$this->_input = substr($this->_input, strlen($match));

				// TODO: genericize discarded tokens
				if ($token == self::T_WHITESPACE) continue;

				// notify for state transitions etc
				$this->_notify($token);

				return array($token, $match);
			}
		}

		throw new Bringit_Cookie_LexerException(sprintf(
			"State '%s' has no matching tokens for: %s",
			$this->_state,
			$this->_input
		));
	}

	/**
	 * @param string
	 */
	private function _notify($token)
	{
		// TODO: does this cause a warning if no transitions for current state?
		if (isset($this->_stateTransitions[$this->_state][$token]))
		{
			$state = $this->_stateTransitions[$this->_state][$token];
			$this->_state = $state;
		}
	}

	/**
	 * @return array
	 * @throws Bringit_Cookie_LexerException
	 */
	private function _stateTokens()
	{
		if (!isset($this->_stateTokens[$this->_state]))
			throw new Bringit_Cookie_LexerException("No tokens for state {$this->_state}");

		return $this->_stateTokens[$this->_state];
	}
}
