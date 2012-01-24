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
		'a_commented_body' => "Vaše odpovìï ^site_title má nový komentáø na ^c_handle:\n\n^open^c_content^close\n\nVaše odpovìï byla:\n\n^open^c_context^close\n\nYou may respond by adding your own comment:\n\n^url\n\nThank you,\n\n^site_title",
		'a_commented_subject' => 'Vaše ^site_title odpovìï má nový komentáø',

		'a_followed_body' => "Vaše odpovìï na ^site_title má novou navazující otázku  ^q_handle:\n\n^open^q_title^close\n\nVaše odpovìï byla :\n\n^open^a_content^close\n\nKlikni dolu k odpovìzení na novou otázku:\n\n^url\n\nThank you,\n\n^site_title",
		'a_followed_subject' => 'Vaše ^site_title odpovìï má související otázku.',

		'a_selected_body' => "Blahopøejeme! Vaše odpovìï na ^site_title byla vybrána jako nejlepší ^s_handle:\n\n^open^a_content^close\n\nThe question was:\n\n^open^q_title^close\n\nClick below to see your answer:\n\n^url\n\nThank you,\n\n^site_title",
		'a_selected_subject' => 'Vaše ^site_title odpovìï byla vybrána!',

		'c_commented_body' => "Nový komentáø od ^c_handle byl pøidán po tom, co byl váš komentáø na ^site_title:\n\n^open^c_content^close\n\nThe diskuze je následující:\n\n^open^c_context^close\n\nYou may respond by adding another comment:\n\n^url\n\nThank you,\n\n^site_title",
		'c_commented_subject' => 'Váš ^site_title komentáø byl pøidán',

		'confirm_body' => "Prosím kliknìte níže, abyste potvrdili Vaši emailovou adresu pro ^site_title.\n\n^url\n\nThank you,\n^site_title",
		'confirm_subject' => '^site_title - Potvrzení emailové adresy',

		'feedback_body' => "Komentáøe:\n^message\n\nName:\n^name\n\nEmail:\n^email\n\nPrevious page:\n^previous\n\nUser:\n^url\n\nIP address:\n^ip\n\nBrowser:\n^browser",
		'feedback_subject' => '^ feedback',

		'flagged_body' => "Pøíspìvek od ^p_handle byl pøijat ^flags:\n\n^open^p_context^close\n\nklikni níže ke shlédnutí pøíspìvku:\n\n^url\n\nThank you,\n\n^site_title",
		'flagged_subject' => '^site_title má ovlajkovaný pøíspìvek',

		'moderate_body' => "Pøíspìvek by ^p_handle vyžaduje Vaše schválení:\n\n^open^p_context^close\n\nClick níže ke schválení nebo odmítnutí pøíspìvku:\n\n^url\n\nThank you,\n\n^site_title",
		'moderate_subject' => '^site_title øízení',

		'new_password_body' => "Vaše nové heslo pro ^site_title je níže.\n\nPassword: ^password\n\nIt je doporuèován ke zmìnì tohoto hesla okamžitì po pøihlášení .\n\nThank you,\n^site_title\n^url",
		'new_password_subject' => '^site_title - Vaše nové heslo',

		'private_message_body' => "Byla Vám zaslána soukromá zpráva od ^f_handle on ^site_title:\n\n^open^message^close\n\n^moreThank you,\n\n^site_title\n\n\nK blokaci soukromých zpráv, navštivte stránku Vašeho úètu:\n^a_url",
		'private_message_info' => "Více informací o ^f_handle:\n\n^url\n\n",
		'private_message_reply' => "Klikni níže k odpovìzení na ^f_handle soukromou zprávu:\n\n^url\n\n",
		'private_message_subject' => 'Zpráva od ^f_handle na ^site_title',

		'q_answered_body' => "Vaše otázka ^site_title byla zodpovìzena ^a_handle:\n\n^open^a_content^close\n\nVaše otázka byla:\n\n^open^q_title^close\n\nPokud se Vám líbí tato odpovìï, mùžete ji oznaèit jako nejlepší:\n\n^url\n\nThank you,\n\n^site_title",
		'q_answered_subject' => 'Vaše ^site_title otázka byla zodpovìzena',

		'q_commented_body' => "Vaše otázka na ^site_title má nový komentáø od ^c_handle:\n\n^open^c_content^close\n\nVaše otázka byla:\n\n^open^c_context^close\n\nYou may respond by adding your own comment:\n\n^url\n\nThank you,\n\n^site_title",
		'q_commented_subject' => 'Vaše ^site_title otázka má nový komentáø',

		'q_posted_body' => "Nová otázka byla položena ^q_handle:\n\n^open^q_title\n\n^q_content^close\n\nKlikni níže ke shlédnutí otázky:\n\n^url\n\nThank you,\n\n^site_title",
		'q_posted_subject' => '^site_title má novou otázku',

		'reset_body' => "Prosím kliknìte níže k obnovení Vašeho hesla pro ^site_title.\n\n^url\n\nAlternativnì, zadejte kód níže do poskytnutého pole.\n\nCode: ^code\n\nPokud jste nepožádali o obnovení Vašeho hesla, ignorujte prosím tuto zprávu.\n\nThank you,\n^site_title",
		'reset_subject' => '^site_title - Obnovit zapomenuté heslo',

		'to_handle_prefix' => "^,\n\n",

		'welcome_body' => "Dìkujeme Vám, že jste se zaregistrovali na ^site_title.\n\n^custom^confirmYour login details are as follows:\n\nEmail: ^email\nPassword: ^password\n\nProsím udržujte tuto informaci v bezpeèí pro budoucí reference.\n\nThank you,\n\n^site_title\n^url",
		'welcome_confirm' => "Prosím kliknìte níže k potvrzení Vaši emailové adresy.\n\n^url\n\n",
		'welcome_subject' => 'Vítejte na ^site_title!',
	);
	

/*
	Omit PHP closing tag to help avoid accidental output
*/