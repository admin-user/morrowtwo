<?php

/*////////////////////////////////////////////////////////////////////////////////
    MorrowTwo - a PHP-Framework for efficient Web-Development
    Copyright (C) 2009  Christoph Erdmann, R.David Cummins

    This file is part of MorrowTwo <http://code.google.com/p/morrowtwo/>

    MorrowTwo is free software:  you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
////////////////////////////////////////////////////////////////////////////////*/






/* add functions that do not exist in all php5 versions
********************************************************************************************/
if (!function_exists('date_default_timezone_set'))
	{
	function date_default_timezone_set ($timezone_identifier)
		{
		putenv("TZ=".$timezone_identifier);
		return TRUE;
		}
	}

/* set default timezone
********************************************************************************************/
date_default_timezone_set('Europe/Berlin');
	
/* do not allow register_globals
********************************************************************************************/
if (ini_get('register_globals'))
	{
	$rg = array_keys($_REQUEST);
	foreach($rg as $var)
		{
		if ($_REQUEST[$var] === $$var) unset($$var);
		}
	}

/* define dump function
********************************************************************************************/
function dump()
	{
	$debug = Factory::load('debug');
	$args = func_get_args();
	echo $debug->dump($args);
	}

/* the autoloader for all classes
********************************************************************************************/
include(FW_PATH.'_core/autoloader.php');

/* load framework
********************************************************************************************/
Factory::load('morrow:morrow:internal');