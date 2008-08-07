<?php

require(dirname(__FILE__).'/../include/init.php');

$basedir = realpath(dirname(__FILE__).'/..');
phool_unshift_include_path(array(
	"$basedir/lib/simpletest",
	"$basedir/tests"
));

if (in_array('--help', $argv))
{
	echo <<<EOM

CLI test runner for Phool.

Available options:

  --with-internet    Include tests which run against live servers (generally http://example.org/).
  --with-reflector   Include tests which run against local HTTP reflector.
  --testfile <path>  Only run the specified test file.
  --help             This documentation.


EOM;

	exit(0);
}


require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');

/**
 * Return array of files matched, decending into subdirectories
 */
function globr($dir, $pattern)
{
		$dir = escapeshellcmd($dir);

		// list of all matching files currently in the directory.
		$files = glob("$dir/$pattern");

		// get a list of all directories in this directory
		foreach (glob("$dir/*", GLOB_ONLYDIR) as $subdir)
		{
				$subfiles = globr($subdir, $pattern);
				$files = array_merge($files, $subfiles);
		}

		return $files;
}

$withInternet = in_array('--with-internet', $argv);
$withReflector = in_array('--with-reflector', $argv);

if (($testFileFlagIndex = array_search('--testfile', $argv)) !== false)
{
	$testFile = $argv[$testFileFlagIndex + 1];
	// TODO: load single test, not GroupTest
	$test = new GroupTest($testFile);
	$test->addTestFile($testFile);
}
else
{
	$test = new GroupTest('All Tests');
	foreach (globr(dirname(__FILE__), '*Test.php') as $testFile)
	{
		if (!$withInternet && preg_match('#/InternetTest/#', $testFile)) continue;
		if (!$withReflector && preg_match('#/HttpReflectorTest/#', $testFile)) continue;

		$test->addTestFile($testFile);
	}
}

$test->run(new TextReporter());

