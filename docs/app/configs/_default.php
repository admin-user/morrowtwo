<?php

// DO NOT CHANGE THIS FILE
// If you want to modify defaults for your project (like routing rules), use the _default_app.php.
// If you want to modify settings per host (like database access settings), create a file for your host/ip.
// This file represents all possible config parameters and is the master default file.

// the session should always be valid only for the current project
$session_path = str_replace('//', '/', str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])).'/');

// we have to take care of the basehref depth
// if the projects public folder is not the document root
if (isset($_GET['morrow_basehref_depth'])) {
	$session_path = preg_replace('|([^/]+/){'.intval($_GET['morrow_basehref_depth']).'}$|', '', $session_path); // Path on the domain where the cookie will work. Use a single slash ('/') for all paths on the domain.
}

return array(
// debug
	'debug.output.screen'			=> (isset($_SERVER['HTTP_HOST']) && preg_match('/\.[a-z]+$/', $_SERVER['HTTP_HOST'])) ? false : true,
	'debug.output.file'				=> (isset($_SERVER['HTTP_HOST']) && preg_match('/\.[a-z]+$/', $_SERVER['HTTP_HOST'])) ? true : false,
	'debug.file.path'				=> STORAGE_PATH .'errors/'. date('Y-m-d') .'.txt',
	
// languages
	'languages'						=> array('en'),
	
// locale/timezone
	'locale.timezone'				=> 'Europe/Berlin',
	
// routing rules
	'routing'						=> array(
		''							=> 'home',
	),
	
// log
	'log.file.path'					=> STORAGE_PATH .'logs/'. date('Y-m-d') .'.txt',
	
// session
	'session.save_path'				=> STORAGE_PATH . 'sessions/', // The path where all sessions are stored (it is also possible to use stream wrappers)
	'session.gc_probability'		=> 1, // In conjunction with gc_divisor it is used to manage probability that the gc (garbage collection) routine is started.
	'session.gc_divisor'			=> 100, // session.gc_divisor coupled with session.gc_probability defines the probability that the gc (garbage collection) process is started on every session initialization. The probability is calculated by using gc_probability/gc_divisor, e.g. 1/100 means there is a 1% chance that the GC process starts on each request.
	'session.gc_maxlifetime'		=> 1440, // Specifies the number of seconds after which data will be seen as 'garbage' and potentially cleaned up. 
	'session.cookie_lifetime'		=> 0, // Lifetime of the session cookie, defined in seconds.
	'session.cookie_path'			=> $session_path, // Path on the domain where the cookie will work. Use a single slash ('/') for all paths on the domain.
	'session.cookie_domain'			=> '', // Cookie domain, for example 'www.php.net'. To make cookies visible on all subdomains then the domain must be prefixed with a dot like '.php.net'.
	'session.cookie_secure'			=> false, // If TRUE cookie will only be sent over secure connections.
	'session.cookie_httponly'		=> true, // If set to TRUE then PHP will attempt to send the httponly flag when setting the session cookie.
	
// OPTIONAL: the following config vars are NOT neccessary for the framework to run
// mailer
	'mail.Mailer'					=> 'mail',
	'mail.From'						=> 'test@example.com',
	'mail.FromName'					=> 'John Doe',
	'mail.WordWrap'					=> 0,
	'mail.Encoding'					=> 'quoted-printable',
	'mail.CharSet'					=> 'utf-8',
	'mail.SMTPAuth'					=> false,
	'mail.Username'					=> '',
	'mail.password'					=> '',
	'mail.Host'						=> '',
	
// db
	'db.driver'						=> 'mysql',
	'db.host'						=> 'localhost',
	'db.db'							=> 'database',
	'db.user'						=> 'user',
	'db.pass'						=> 'pass',
	'db.encoding'					=> 'utf8',
	
// sitesearch
	'sitesearch.buildindex'			=> 'true',
	'sitesearch.exclude_patterns'	=> array(),
	'sitesearch.tag_include_start'	=> '<!-- search_include_start -->',
	'sitesearch.tag_include_end'	=> '<!-- search_include_end -->',
	'sitesearch.tag_exclude_start'	=> '<!-- search_exclude_start -->',
	'sitesearch.tag_exclude_end'	=> '<!-- search_exclude_end -->',
	'sitesearch.check_divisor'		=> 10,
	'sitesearch.gc_divisor'			=> 100,
	'sitesearch.entry_lifetime'		=> '+1 month',
	'sitesearch.db.driver'			=> 'sqlite',
	'sitesearch.db.file'			=> STORAGE_PATH .'sitesearch.sqlite',
	'sitesearch.db.host'			=> 'localhost',
	'sitesearch.db.db'				=> 'sitesearch_searchengine',
	'sitesearch.db.user'			=> 'root',
	'sitesearch.db.pass'			=> '',
	'sitesearch.db_tablename'		=> 'searchdata',
	
// message queue
	'messagequeue.cli_path'			=> 'php',
	'messagequeue.save_path'		=> STORAGE_PATH . 'messagequeue/',
);
