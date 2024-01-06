<?php if ( ! defined('TS_HEADER')) exit('No direct script access allowed');

/**
 * Index :: Instrucciones para el instalador
 *
 * @package Syntaxis Lite Install
 * @author Miguel92 
 * @copyright Syntaxis Lite 2024
 * @version v2.0 01-01-2024
 * @link https://phpost.es
*/

$db = [
	'hostname' => 'dbhost',

	'username' => 'dbuser',

	'password' => 'dbpass',

	'database' => 'dbname',

	'setnames' => 'utf8mb4',

	'cookiename' => 'PHPost'
];

define('TSCookieName',$db['cookiename']);

$display['msgs'] = 1;
