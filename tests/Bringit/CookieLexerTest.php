<?php

class Bringit_CookieLexerTest extends UnitTestCase
{
	public function testMinimalCookie()
	{
		$tokens = $this->_tokenize('a=b');

		$this->_assertTokens($tokens, array(
			'name{a}', 'equals{=}', 'value{b}'));
	}

	public function testMinimalCookieWithWhiteSpace()
	{
		$tokens = $this->_tokenize('a =  b');

		$this->_assertTokens($tokens, array(
			'name{a}', 'equals{=}', 'value{b}'));
	}

	public function testMinimalQuotedValue()
	{
		$tokens = $this->_tokenize('example="example cookie"');

		$this->_assertTokens($tokens, array(
			'name{example}',
			'equals{=}',
			'doublequote{"}',
			'value{example cookie}',
			'doublequote{"}'
		));
	}

	public function testWithAttributes()
	{
		$tokens = $this->_tokenize(
			'example="example cookie"; Path=/; Domain=".example.org"; Port = 80');

		$this->_assertTokens($tokens, array(
			'name{example}',
			'equals{=}',
			'doublequote{"}',
			'value{example cookie}',
			'doublequote{"}',
			'semicolon{;}',
			'name{Path}',
			'equals{=}',
			'value{/}',
			'semicolon{;}',
			'name{Domain}',
			'equals{=}',
			'doublequote{"}',
			'value{.example.org}',
			'doublequote{"}',
			'semicolon{;}',
			'name{Port}',
			'equals{=}',
			'value{80}',
		));
	}

	public function testTwoCookies()
	{
		$tokens = $this->_tokenize(
			'e1="example cookie"; Path="/test", ' .
			'e2="second example"; Domain=".example.org";');

		$this->_assertTokens($tokens, array(
			'name{e1}',
			'equals{=}',
			'doublequote{"}',
			'value{example cookie}',
			'doublequote{"}',
			'semicolon{;}',
			'name{Path}',
			'equals{=}',
			'doublequote{"}',
			'value{/test}',
			'doublequote{"}',
			'comma{,}',
			'name{e2}',
			'equals{=}',
			'doublequote{"}',
			'value{second example}',
			'doublequote{"}',
			'semicolon{;}',
			'name{Domain}',
			'equals{=}',
			'doublequote{"}',
			'value{.example.org}',
			'doublequote{"}',
			'semicolon{;}',
		));
	}

	public function testEscapedQuoteInValue()
	{
		$tokens = $this->_tokenize(
			'example="example \"cookie\" with escaped quotes"');

		$this->_assertTokens($tokens, array(
			'name{example}',
			'equals{=}',
			'doublequote{"}',
			'value{example \"cookie\" with escaped quotes}',
			'doublequote{"}'
		));
	}

	public function testEscapedQuoteAtEndOfValue()
	{
		$tokens = $this->_tokenize('example="example \"cookie\""');

		$this->_assertTokens($tokens, array(
			'name{example}',
			'equals{=}',
			'doublequote{"}',
			'value{example \"cookie\"}',
			'doublequote{"}'
		));
	}

	public function testDollarNames()
	{
		$tokens = $this->_tokenize('a=b; $Version=2');
		$this->_assertTokens($tokens, array(
			'name{a}',
			'equals{=}',
			'value{b}',
			'semicolon{;}',
			'name{$Version}',
			'equals{=}',
			'value{2}',
		));
	}

	public function testUnlexable()
	{
		$this->expectException('Bringit_Cookie_LexerException');
		$this->_tokenize('this is not a cookie');
	}

	// ----------------------------------------

	private function _tokenize($string)
	{
		$tokens = array();

		$lexer = new Bringit_Cookie_CookieLexer($string);

		while ($token = $lexer->next())
			$tokens []= $token;

		return $tokens;
	}

	private function _assertTokens($tokens, $strings)
	{
		if (count($tokens) != count($strings))
		{
			$this->fail("Incorrect token count");
			return;
		}

		foreach ($tokens as $i => $token)
		{
			$this->assertEqual(
				sprintf('%s{%s}', $token[0], $token[1]),
				$strings[$i]
			);
		}
	}

	private function _debug($tokens)
	{
		foreach ($tokens as $token)
			printf("%s[%s]\n", $token[0], $token[1]);
	}
}
