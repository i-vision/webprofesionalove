<?php
/*
	Plugin Name: History
	Plugin URI: https://github.com/NoahY/q2a-history
	Plugin Description: Adds complete activity history list to user profile
	Plugin Version: 1.0
	Plugin Date: 2011-10-26
	Plugin Author: NoahY
	Plugin Author URI: http://www.question2answer.org/qa/user/NoahY
	Plugin License: GPLv3
	Plugin Minimum Question2Answer Version: 1.4
	Plugin Update Check URI: https://raw.github.com/NoahY/q2a-history/master/qa-plugin.php

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.gnu.org/licenses/gpl.html
	
*/

if ( !defined('QA_VERSION') )
{
	header('Location: ../../');
	exit;
}

qa_register_plugin_layer('qa-history-layer.php', 'History Layer');
qa_register_plugin_module('event', 'qa-history-check.php','history_check','History Check');
qa_register_plugin_module('module', 'qa-history-admin.php','history_admin','History Admin');
