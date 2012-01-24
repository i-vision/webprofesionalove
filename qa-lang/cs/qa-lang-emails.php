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
		'a_commented_body' => "Vaše odpověď ^site_title má nový komentář na ^c_handle:\n\n^open^c_content^close\n\nVaše odpověď byla:\n\n^open^c_context^close\n\nYou may respond by adding your own comment:\n\n^url\n\nThank you,\n\n^site_title",
		'a_commented_subject' => 'Vaše ^site_title odpověď má nový komentář',

		'a_followed_body' => "Vaše odpověď na ^site_title má novou navazující otázku  ^q_handle:\n\n^open^q_title^close\n\nVaše odpověď byla :\n\n^open^a_content^close\n\nKlikni dolu k odpovězení na novou otázku:\n\n^url\n\nThank you,\n\n^site_title",
		'a_followed_subject' => 'Vaše ^site_title odpověď má související otázku.',

		'a_selected_body' => "Blahopřejeme! Vaše odpověď na ^site_title byla vybrána jako nejlepší ^s_handle:\n\n^open^a_content^close\n\nThe question was:\n\n^open^q_title^close\n\nClick below to see your answer:\n\n^url\n\nThank you,\n\n^site_title",
		'a_selected_subject' => 'Vaše ^site_title odpověď byla vybrána!',

		'c_commented_body' => "Nový komentář od ^c_handle byl přidán po tom, co byl váš komentář na ^site_title:\n\n^open^c_content^close\n\nThe diskuze je následující:\n\n^open^c_context^close\n\nYou may respond by adding another comment:\n\n^url\n\nThank you,\n\n^site_title",
		'c_commented_subject' => 'Váš ^site_title komentář byl přidán',

		'confirm_body' => "Prosím klikněte níže, abyste potvrdili Vaši emailovou adresu pro ^site_title.\n\n^url\n\nThank you,\n^site_title",
		'confirm_subject' => '^site_title - Potvrzení emailové adresy',

		'feedback_body' => "Komentáře:\n^message\n\nName:\n^name\n\nEmail:\n^email\n\nPrevious page:\n^previous\n\nUser:\n^url\n\nIP address:\n^ip\n\nBrowser:\n^browser",
		'feedback_subject' => '^ feedback',

		'flagged_body' => "Příspěvek od ^p_handle byl přijat ^flags:\n\n^open^p_context^close\n\nklikni níže ke shlédnutí příspěvku:\n\n^url\n\nThank you,\n\n^site_title",
		'flagged_subject' => '^site_title má ovlajkovaný příspěvek',

		'moderate_body' => "Příspěvek by ^p_handle vyžaduje Vaše schválení:\n\n^open^p_context^close\n\nClick níže ke schválení nebo odmítnutí příspěvku:\n\n^url\n\nThank you,\n\n^site_title",
		'moderate_subject' => '^site_title řízení',

		'new_password_body' => "Vaše nové heslo pro ^site_title je níže.\n\nPassword: ^password\n\nIt je doporučován ke změně tohoto hesla okamžitě po přihlášení .\n\nThank you,\n^site_title\n^url",
		'new_password_subject' => '^site_title - Vaše nové heslo',

		'private_message_body' => "Byla Vám zaslána soukromá zpráva od ^f_handle on ^site_title:\n\n^open^message^close\n\n^moreThank you,\n\n^site_title\n\n\nK blokaci soukromých zpráv, navštivte stránku Vašeho účtu:\n^a_url",
		'private_message_info' => "Více informací o ^f_handle:\n\n^url\n\n",
		'private_message_reply' => "Klikni níže k odpovězení na ^f_handle soukromou zprávu:\n\n^url\n\n",
		'private_message_subject' => 'Zpráva od ^f_handle na ^site_title',

		'q_answered_body' => "Vaše otázka ^site_title byla zodpovězena ^a_handle:\n\n^open^a_content^close\n\nVaše otázka byla:\n\n^open^q_title^close\n\nPokud se Vám líbí tato odpověď, můžete ji označit jako nejlepší:\n\n^url\n\nThank you,\n\n^site_title",
		'q_answered_subject' => 'Vaše ^site_title otázka byla zodpovězena',

		'q_commented_body' => "Vaše otázka na ^site_title má nový komentář od ^c_handle:\n\n^open^c_content^close\n\nVaše otázka byla:\n\n^open^c_context^close\n\nYou may respond by adding your own comment:\n\n^url\n\nThank you,\n\n^site_title",
		'q_commented_subject' => 'Vaše ^site_title otázka má nový komentář',

		'q_posted_body' => "Nová otázka byla položena ^q_handle:\n\n^open^q_title\n\n^q_content^close\n\nKlikni níže ke shlédnutí otázky:\n\n^url\n\nThank you,\n\n^site_title",
		'q_posted_subject' => '^site_title má novou otázku',

		'reset_body' => "Prosím klikněte níže k obnovení Vašeho hesla pro ^site_title.\n\n^url\n\nAlternativně, zadejte kód níže do poskytnutého pole.\n\nCode: ^code\n\nPokud jste nepožádali o obnovení Vašeho hesla, ignorujte prosím tuto zprávu.\n\nThank you,\n^site_title",
		'reset_subject' => '^site_title - Obnovit zapomenuté heslo',

		'to_handle_prefix' => "^,\n\n",

		'welcome_body' => "Děkujeme Vám, že jste se zaregistrovali na ^site_title.\n\n^custom^confirmYour login details are as follows:\n\nEmail: ^email\nPassword: ^password\n\nProsím udržujte tuto informaci v bezpečí pro budoucí reference.\n\nThank you,\n\n^site_title\n^url",
		'welcome_confirm' => "Prosím klikněte níže k potvrzení Vaši emailové adresy.\n\n^url\n\n",
		'welcome_subject' => 'Vítejte na ^site_title!',
	);
	

/*
	Omit PHP closing tag to help avoid accidental output
*/