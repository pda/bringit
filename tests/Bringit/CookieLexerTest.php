<?php

class Bringit_Cookie2ParserTest extends UnitTestCase
{
	public function testMinimalCookie()
	{
		$lexer = new Bringit_Cookie_CookieLexer();
		$tokens = $lexer->tokenize('a=b');
		$this->assertEqual(count($tokens), 3);
		// TODO: assert correct tokens
	}

	public function testMinimalCookieWithWhiteSpace()
	{
		$lexer = new Bringit_Cookie_CookieLexer();
		$tokens = $lexer->tokenize('a =  b');
		$this->assertEqual(count($tokens), 3);
		// TODO: assert correct tokens
	}

	public function testMinimalQuotedValue()
	{
		$lexer = new Bringit_Cookie_CookieLexer();
		$tokens = $lexer->tokenize('example="example cookie"');
		$this->assertEqual(count($tokens), 5);
		// TODO: assert correct tokens
	}

	public function testWithAttributes()
	{
		$lexer = new Bringit_Cookie_CookieLexer();
		$tokens = $lexer->tokenize(
			'example="example cookie"; Path=/; Domain=".example.org"; Port = 80');
		$this->assertEqual(count($tokens), 19);
		// TODO: assert correct tokens
	}

	public function testTwoCookies()
	{
		$lexer = new Bringit_Cookie_CookieLexer();
		$tokens = $lexer->tokenize(
			'e1="example cookie"; Path="/test", ' .
			'e2="second example"; Domain=".example.org";');
		$this->assertEqual(count($tokens), 24);
		// TODO: assert correct tokens
	}

	public function testEscapedQuoteInValue()
	{
		$lexer = new Bringit_Cookie_CookieLexer();
		$tokens = $lexer->tokenize('example="example \"cookie\" with escaped quotes"');
		$this->assertEqual(count($tokens), 5);
		// TODO: assert correct tokens
		$this->_debug($tokens);
	}

	public function testDollarNames()
	{
		$lexer = new Bringit_Cookie_CookieLexer();
		$tokens = $lexer->tokenize('a=b; $Version=2');
		$this->assertEqual(count($tokens), 7);
		// TODO: assert correct tokens
	}

	// ----------------------------------------

	private function _debug($tokens)
	{
		foreach ($tokens as $token)
			printf("%s[%s]\n", $token[0], $token[1]);
	}
}
