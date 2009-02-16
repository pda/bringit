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
			self::T_DOUBLEQUOTE => '(?<!")"',
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

	private $_state = self::STATE_ROOT;

	/**
	 * Tokenizes the value of a Set-Cookie or Set-Cookie2 header.
	 * @param string
	 * @return array
	 */
	public function tokenize($string)
	{
		$tokens = array();

		// TODO: refactor to be less loopy, more iteratory.
		while (strlen($string))
		{
			foreach ($this->_stateTokens() as $token => $reBody)
			{
				$re = "#^{$reBody}#";

				if (preg_match($re, $string, $matches))
				{
					$string = substr($string, strlen($matches[0]));

					if ($token == self::T_WHITESPACE) continue(2);

					$tokens []= array($token, $matches[0]);

					// notify for state transitions etc
					$this->_notify($token);

					continue(2);
				}
			}

			throw new Bringit_Cookie_LexerException(
				"State '{$this->_state}': no matching tokens for $string");
		}

		return $tokens;
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
