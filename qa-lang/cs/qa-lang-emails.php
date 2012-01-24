<?php
	
/*
	Question2Answer (c) Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-include/qa-lang-emails.php
	Version: See define()s at top of qa-include/qa-base.php
	Description: Language phrases for email notifications


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

	return array(
		'a_commented_body' => "Va�e odpov�� ^site_title m� nov� koment�� na ^c_handle:\n\n^open^c_content^close\n\nVa�e odpov�� byla:\n\n^open^c_context^close\n\nYou may respond by adding your own comment:\n\n^url\n\nThank you,\n\n^site_title",
		'a_commented_subject' => 'Va�e ^site_title odpov�� m� nov� koment��',

		'a_followed_body' => "Va�e odpov�� na ^site_title m� novou navazuj�c� ot�zku  ^q_handle:\n\n^open^q_title^close\n\nVa�e odpov�� byla :\n\n^open^a_content^close\n\nKlikni dolu k odpov�zen� na novou ot�zku:\n\n^url\n\nThank you,\n\n^site_title",
		'a_followed_subject' => 'Va�e ^site_title odpov�� m� souvisej�c� ot�zku.',

		'a_selected_body' => "Blahop�ejeme! Va�e odpov�� na ^site_title byla vybr�na jako nejlep�� ^s_handle:\n\n^open^a_content^close\n\nThe question was:\n\n^open^q_title^close\n\nClick below to see your answer:\n\n^url\n\nThank you,\n\n^site_title",
		'a_selected_subject' => 'Va�e ^site_title odpov�� byla vybr�na!',

		'c_commented_body' => "Nov� koment�� od ^c_handle byl p�id�n po tom, co byl v� koment�� na ^site_title:\n\n^open^c_content^close\n\nThe diskuze je n�sleduj�c�:\n\n^open^c_context^close\n\nYou may respond by adding another comment:\n\n^url\n\nThank you,\n\n^site_title",
		'c_commented_subject' => 'V� ^site_title koment�� byl p�id�n',

		'confirm_body' => "Pros�m klikn�te n�e, abyste potvrdili Va�i emailovou adresu pro ^site_title.\n\n^url\n\nThank you,\n^site_title",
		'confirm_subject' => '^site_title - Potvrzen� emailov� adresy',

		'feedback_body' => "Koment��e:\n^message\n\nName:\n^name\n\nEmail:\n^email\n\nPrevious page:\n^previous\n\nUser:\n^url\n\nIP address:\n^ip\n\nBrowser:\n^browser",
		'feedback_subject' => '^ feedback',

		'flagged_body' => "P��sp�vek od ^p_handle byl p�ijat ^flags:\n\n^open^p_context^close\n\nklikni n�e ke shl�dnut� p��sp�vku:\n\n^url\n\nThank you,\n\n^site_title",
		'flagged_subject' => '^site_title m� ovlajkovan� p��sp�vek',

		'moderate_body' => "P��sp�vek by ^p_handle vy�aduje Va�e schv�len�:\n\n^open^p_context^close\n\nClick n�e ke schv�len� nebo odm�tnut� p��sp�vku:\n\n^url\n\nThank you,\n\n^site_title",
		'moderate_subject' => '^site_title ��zen�',

		'new_password_body' => "Va�e nov� heslo pro ^site_title je n�e.\n\nPassword: ^password\n\nIt je doporu�ov�n ke zm�n� tohoto hesla okam�it� po p�ihl�en� .\n\nThank you,\n^site_title\n^url",
		'new_password_subject' => '^site_title - Va�e nov� heslo',

		'private_message_body' => "Byla V�m zasl�na soukrom� zpr�va od ^f_handle on ^site_title:\n\n^open^message^close\n\n^moreThank you,\n\n^site_title\n\n\nK blokaci soukrom�ch zpr�v, nav�tivte str�nku Va�eho ��tu:\n^a_url",
		'private_message_info' => "V�ce informac� o ^f_handle:\n\n^url\n\n",
		'private_message_reply' => "Klikni n�e k odpov�zen� na ^f_handle soukromou zpr�vu:\n\n^url\n\n",
		'private_message_subject' => 'Zpr�va od ^f_handle na ^site_title',

		'q_answered_body' => "Va�e ot�zka ^site_title byla zodpov�zena ^a_handle:\n\n^open^a_content^close\n\nVa�e ot�zka byla:\n\n^open^q_title^close\n\nPokud se V�m l�b� tato odpov��, m��ete ji ozna�it jako nejlep��:\n\n^url\n\nThank you,\n\n^site_title",
		'q_answered_subject' => 'Va�e ^site_title ot�zka byla zodpov�zena',

		'q_commented_body' => "Va�e ot�zka na ^site_title m� nov� koment�� od ^c_handle:\n\n^open^c_content^close\n\nVa�e ot�zka byla:\n\n^open^c_context^close\n\nYou may respond by adding your own comment:\n\n^url\n\nThank you,\n\n^site_title",
		'q_commented_subject' => 'Va�e ^site_title ot�zka m� nov� koment��',

		'q_posted_body' => "Nov� ot�zka byla polo�ena ^q_handle:\n\n^open^q_title\n\n^q_content^close\n\nKlikni n�e ke shl�dnut� ot�zky:\n\n^url\n\nThank you,\n\n^site_title",
		'q_posted_subject' => '^site_title m� novou ot�zku',

		'reset_body' => "Pros�m klikn�te n�e k obnoven� Va�eho hesla pro ^site_title.\n\n^url\n\nAlternativn�, zadejte k�d n�e do poskytnut�ho pole.\n\nCode: ^code\n\nPokud jste nepo��dali o obnoven� Va�eho hesla, ignorujte pros�m tuto zpr�vu.\n\nThank you,\n^site_title",
		'reset_subject' => '^site_title - Obnovit zapomenut� heslo',

		'to_handle_prefix' => "^,\n\n",

		'welcome_body' => "D�kujeme V�m, �e jste se zaregistrovali na ^site_title.\n\n^custom^confirmYour login details are as follows:\n\nEmail: ^email\nPassword: ^password\n\nPros�m udr�ujte tuto informaci v bezpe�� pro budouc� reference.\n\nThank you,\n\n^site_title\n^url",
		'welcome_confirm' => "Pros�m klikn�te n�e k potvrzen� Va�i emailov� adresy.\n\n^url\n\n",
		'welcome_subject' => 'V�tejte na ^site_title!',
	);
	

/*
	Omit PHP closing tag to help avoid accidental output
*/