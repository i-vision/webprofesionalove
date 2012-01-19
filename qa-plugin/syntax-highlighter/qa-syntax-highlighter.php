<?php

/*
	Syntax Highlighter Plugin for Question2Answer 1.3 (c) 2011, Ernest Mikolajczyk

	http://www.quanda.pl/

	
	File: qa-plugin/syntax-highlighter/qa-syntax-highlighter.php
	Version: 1.1
	Date: 2011-01-20 22:43:00 GMT
	Description: Highlights syntax using Alex Gorbachev Syntax Highlighter
	The plugin is based on qa-viewer-basic.php version 1.3 by Gideon Greenspan

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

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}

	class qa_syntax_highlighter {
	
		var $htmllineseparators;
		var $htmlparagraphseparators;
		var $urltoroot;
		var $scriptloaded;
		var $aliases = array();
		var $languagesregex;
		var $default_language = 'php';


		// Set some variables now that we've given all other plugins a chance to load
		function SetVariables() {
		
			$this->aliases = array('bash', 'sh', 'shell', 'cpp', 'c', 'c++', 'c#', 'c-sharp', 'csharp', 'css', 'delphi', 'pascal', 'diff', 'patch', 'groovy', 'java', 'js', 'jscript', 'javascript', 'perl', 'pl', 'php', '', 'plain', 'text', 'py', 'python', 'rb', 'ruby', 'rails', 'ror', 'scala', 'sql', 'vb', 'vbnet', 'vb.net', 'xml', 'html', 'xhtml', 'xslt') ;
			
			foreach ($this->aliases as &$alias)
			{
				$alias = preg_quote($alias);
			}

			// Generate the regex for them
			$this->languagesregex = '(' . implode( '|', $this->aliases ) . ')';
		}


		// This function checks for the BBCode cheaply so we don't waste CPU cycles on regex if it's not needed
		// It's in a seperate function since it's used in mulitple places (makes it easier to edit)
		function CheckForBBCode( $content ) {
			if ( stristr( $content, '[sourcecode' ) && stristr( $content, '[/sourcecode]' ) ) return TRUE;
			if ( stristr( $content, '[source' ) && stristr( $content, '[/source]' ) ) return TRUE;
			if ( stristr( $content, '[code' ) && stristr( $content, '[/code]' ) ) return TRUE;
			if ( stristr( $content, '[lang' ) && stristr( $content, '[/lang]' ) ) return TRUE;
			
			foreach ($this->aliases as $alias)
			{
				if ( stristr( $content, '['.$alias ) && stristr( $content, '[/'.$alias.']' ) ) return TRUE;
			}

			return FALSE;
		}


		// This function is a wrapper for preg_match_all() that grabs all BBCode calls
		// It's in a seperate function since it's used in mulitple places (makes it easier to edit)
		function GetBBCode( $content, $addslashes = FALSE ) {
			$regex = '/\[(sourcecode|source|code|lang|)( language=| lang=|=|)';
			if ( $addslashes ) $regex .= '\\\\';
			$regex .= '([\'"]|)' . $this->languagesregex;
			if ( $addslashes ) $regex .= '\\\\';
			$regex .= '\3\](.*?)\[\/(\1|\4)\]/si';

			preg_match_all( $regex, $content, $matches, PREG_SET_ORDER );
			
			return $matches;
		}


		// The meat of the plugin. Find all valid BBCode calls and replace them with HTML for the Javascript to handle.
		function BBCodeToHTML( $content ) {
			if ( !$this->CheckForBBCode( $content ) ){
				return $content;
			}	

			$matches = $this->GetBBCode( $content );

			if ( empty($matches) ){
				echo($this->languagesregex);
				return $content; // No BBCode found, we can stop here
			}

			// Loop through each match and replace the BBCode with HTML
			foreach ( (array) $matches as $match ) {
				$language = $match[4] == '' ? $this->default_language : strtolower( $match[4] ); 
				$content = str_replace( $match[0], '<pre class="brush: ' . $language . "\">" . strip_tags($match[5]) . "</pre>", $content );
			}
			
			return $content;
		}
		
		function load_module($localdir, $htmldir)
		{
			$this->htmllineseparators='br|option';
			$this->htmlparagraphseparators='address|applet|blockquote|center|cite|code|col|div|dd|dl|dt|embed|form|frame|frameset|h1|h2|h3|h4|h5|h6'.
				'|hr|iframe|input|li|marquee|ol|p|pre|samp|select|spacer|table|tbody|td|textarea|tfoot|th|thead|tr|ul|sourcecode';
			$this->urltoroot=$htmldir;
			$this->scriptloaded = false;
			$this->scripthighlighted = false;
			$this->SetVariables();

		}
		
		function calc_quality($content, $format)
		{
			if ( ($format=='') || ($format=='html') )
				return 1.5;
			else
				return 0;
		}
		
		function get_html($content, $format, $options)
		{
			if ($format=='html') {
				$html=$content;

				if (isset($options['blockwordspreg'])) { // filtering out blocked words inline within HTML is pretty complex, e.g. p<B>oo</B>p must be caught
					require_once QA_INCLUDE_DIR.'qa-util-string.php';

					$html=preg_replace('/<\s*('.$this->htmllineseparators.')[^A-Za-z0-9]/i', "\n\\0", $html); // tags to single new line
					$html=preg_replace('/<\s*('.$this->htmlparagraphseparators.')[^A-Za-z0-9]/i', "\n\n\\0", $html); // tags to double new line
					
					preg_match_all('/<[^>]*>/', $html, $pregmatches, PREG_OFFSET_CAPTURE); // find tag positions and lengths
					$tagmatches=$pregmatches[0];
					$text=preg_replace('/<[^>]*>/', '', $html); // effectively strip_tags() but use same regexp as above to ensure consistency

					$blockmatches=qa_block_words_match_all($text, $options['blockwordspreg']); // search for blocked words within text
					
					$nexttagmatch=array_shift($tagmatches);
					$texttohtml=0;
					$htmlshift=0;

					foreach ($blockmatches as $textoffset => $textlength) {
						while ( isset($nexttagmatch) && ($nexttagmatch[1]<=($textoffset+$texttohtml)) ) { // keep text and html in sync
							$texttohtml+=strlen($nexttagmatch[0]);
							$nexttagmatch=array_shift($tagmatches);
						}
						
						while (1) {
							$replacepart=$textlength;
							if (isset($nexttagmatch))
								$replacepart=min($replacepart, $nexttagmatch[1]-($textoffset+$texttohtml)); // stop replacing early if we hit an HTML tag
							
							$replacelength=qa_strlen(substr($text, $textoffset, $replacepart)); // to work with multi-byte characters
							
							$html=substr_replace($html, str_repeat('*', $replacelength), $textoffset+$texttohtml+$htmlshift, $replacepart);
							$htmlshift+=$replacelength-$replacepart; // HTML might have moved around if we replaced multi-byte characters
							
							if ($replacepart>=$textlength)
								break; // we have replaced everything expected, otherwise more left (due to hitting an HTML tag)
							
							$textlength-=$replacepart;
							$textoffset+=$replacepart;
							$texttohtml+=strlen($nexttagmatch[0]);
							$nexttagmatch=array_shift($tagmatches);
						}
					}
				}					
				
			} else {
				if (isset($options['blockwordspreg'])) {
					require_once QA_INCLUDE_DIR.'qa-util-string.php';
					$content=qa_block_words_replace($content, $options['blockwordspreg']);
				}
				
				$html=qa_html($content, true);
				
				if (@$options['showurllinks']) {
					require_once QA_INCLUDE_DIR.'qa-app-format.php';
					$html=qa_html_convert_urls($html);
				}
			}

			$html=$this->BBCodeToHTML($html);

			if (!$this->scriptloaded) {
				$this->scriptloaded = true;
				$html='<link type="text/css" rel="stylesheet" href="'.$this->urltoroot.'styles/shCoreDefault.css"/>'.$html;
				$html='<script type="text/javascript" src="'.$this->urltoroot.'scripts/shAutoloader.js"></script>'.$html;
				$html='<script type="text/javascript" src="'.$this->urltoroot.'scripts/shCore.js"></script>'.$html;
				$html.='<script type="text/javascript">
				var hl_oldOnLoad = window.onload; 
				window.onload = function(){
					if (typeof hl_oldOnLoad == \'function\')  
						hl_oldOnLoad(); 
					SyntaxHighlighter.autoloader(
						\'applescript            '.$this->urltoroot.'scripts/shBrushAppleScript.js\',
						\'actionscript3 as3      '.$this->urltoroot.'scripts/shBrushAS3.js\',
						\'bash shell             '.$this->urltoroot.'scripts/shBrushBash.js\',
						\'coldfusion cf          '.$this->urltoroot.'scripts/shBrushColdFusion.js\',
						\'cpp c                  '.$this->urltoroot.'scripts/shBrushCpp.js\',
						\'c# c-sharp csharp      '.$this->urltoroot.'scripts/shBrushCSharp.js\',
						\'css                    '.$this->urltoroot.'scripts/shBrushCss.js\',
						\'delphi pascal          '.$this->urltoroot.'scripts/shBrushDelphi.js\',
						\'diff patch pas         '.$this->urltoroot.'scripts/shBrushDiff.js\',
						\'erl erlang             '.$this->urltoroot.'scripts/shBrushErlang.js\',
						\'groovy                 '.$this->urltoroot.'scripts/shBrushGroovy.js\',
						\'java                   '.$this->urltoroot.'scripts/shBrushJava.js\',
						\'jfx javafx             '.$this->urltoroot.'scripts/shBrushJavaFX.js\',
						\'js jscript javascript  '.$this->urltoroot.'scripts/shBrushJScript.js\',
						\'perl pl                '.$this->urltoroot.'scripts/shBrushPerl.js\',
						\'php                    '.$this->urltoroot.'scripts/shBrushPhp.js\',
						\'text plain             '.$this->urltoroot.'scripts/shBrushPlain.js\',
						\'py python              '.$this->urltoroot.'scripts/shBrushPython.js\',
						\'ruby rails ror rb      '.$this->urltoroot.'scripts/shBrushRuby.js\',
						\'sass scss              '.$this->urltoroot.'scripts/shBrushSass.js\',
						\'scala                  '.$this->urltoroot.'scripts/shBrushScala.js\',
						\'sql                    '.$this->urltoroot.'scripts/shBrushSql.js\',
						\'vb vbnet               '.$this->urltoroot.'scripts/shBrushVb.js\',
						\'xml xhtml xslt html    '.$this->urltoroot.'scripts/shBrushXml.js\'
					);
					SyntaxHighlighter.config.stripBrs = true;
					SyntaxHighlighter.all()
				}
	
				</script>';
			} 
			return $html;
		}

		function get_text($content, $format, $options)
		{
			if ($format=='html') {
				$text=strtr($content, "\n\r\t", '   '); // convert all white space in HTML to spaces
				$text=preg_replace('/<\s*('.$this->htmllineseparators.')[^A-Za-z0-9]/i', "\n\\0", $text); // tags to single new line
				$text=preg_replace('/<\s*('.$this->htmlparagraphseparators.')[^A-Za-z0-9]/i', "\n\n\\0", $text); // tags to double new line
				$text=strip_tags($text); // all tags removed
				$text=preg_replace('/  +/', ' ', $text); // combine multiple spaces into one
				$text=preg_replace('/ *\n */', "\n", $text); // remove spaces either side new lines
				$text=preg_replace('/\n\n\n+/', "\n\n", $text); // more than two new lines combine into two
				$text=strtr($text, array(
					'&#34;' => "\x22",
					'&#38;' => "\x26",
					'&#39;' => "\x27",
					'&#60;' => "\x3C",
					'&#62;' => "\x3E",
					'&nbsp;' => " ",
					'&quot;' => "\x22",
					'&amp;' => "\x26",
					'&lt;' => "\x3C",
					'&gt;' => "\x3E",
				)); // base HTML entities (others should not be stored in database)
				
				$text=trim($text);

			} else
				$text=$content;
				
			if (isset($options['blockwordspreg'])) {
				require_once QA_INCLUDE_DIR.'qa-util-string.php';
				$text=qa_block_words_replace($text, $options['blockwordspreg']);
			}

			return $text;
		}
	
	};
	

/*
	Omit PHP closing tag to help avoid accidental output
*/