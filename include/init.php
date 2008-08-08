<?php
/**
 * Phool init script.
 * Sets up include paths based on the directory this file is in.
 * Registers an SPL class autoload function.
 *
 * @author Paul Annesley
 * @package Phool
 * @licence http://www.opensource.org/licenses/mit-license.php
 */

ini_set('display_errors', true);
error_reporting(E_ALL);

$basedir = realpath(dirname(__FILE__).'/..');

require_once("$basedir/classes/Phool/ClassLoader.php");
Phool_ClassLoader::register();
Phool_ClassLoader::addIncludePath(array(
	"$basedir/classes",
	"$basedir/lib"
));

