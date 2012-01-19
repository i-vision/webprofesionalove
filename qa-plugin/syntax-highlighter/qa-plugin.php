<?php

/*
	Syntax Highlighter Plugin for Question2Answer 1.3 (c) 2011, Ernest Mikolajczyk

	http://www.quanda.pl/

	
	File: qa-plugin/syntax-highlighter/qa-plugin.php
	Version: 1.1
	Date: 2011-01-20 22:43:00 GMT
	Description: Highlights syntax using Alex Gorbachev Syntax Highlighter


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	Credits:
	Thanks to Soul_Assassin for eliminating html tags in BBCodeToHTML function
*/

/*
	Plugin Name: Syntax Highlighter
	Plugin URI: 
	Plugin Description: Syntax highlighting plugin using Alex Gorbachev Syntax highlighter
	Plugin Version: 1.1
	Plugin Date: 2011-01-20
	Plugin Author: Ernest Mikolajczyk
	Plugin Author URI: http://www.quanda.pl/
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.3
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}

	qa_register_plugin_module('viewer', 'qa-syntax-highlighter.php', 'qa_syntax_highlighter', 'Syntax Highlighter');

/*
	Omit PHP closing tag to help avoid accidental output
*/