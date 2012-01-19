<?php

class qa_html_theme_layer extends qa_html_theme_base
{

	function doctype() {
		if(qa_get_logged_in_userid() && qa_opt('user_act_list_active') && qa_opt('user_act_list_new') && ($this->template != 'user' || qa_get_logged_in_handle() != $this->_user_handle())) {

			qa_db_query_sub(
				'CREATE TABLE IF NOT EXISTS ^usermeta (
				meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				user_id bigint(20) unsigned NOT NULL,
				meta_key varchar(255) DEFAULT NULL,
				meta_value longtext,
				PRIMARY KEY (meta_id),
				UNIQUE (user_id,meta_key)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8'
			);		

			$last_visit = qa_db_read_one_value(
				qa_db_query_sub(
					'SELECT UNIX_TIMESTAMP(meta_value) FROM ^usermeta WHERE user_id=# AND meta_key=$',
					qa_get_logged_in_userid(), 'visited_profile'
				),
				true
			);
			if($last_visit) {
				$events = qa_db_read_one_value(
					qa_db_query_sub(
						'SELECT COUNT(event) FROM ^eventlog WHERE userid=# AND DATE_SUB(CURDATE(),INTERVAL # DAY) <= datetime AND FROM_UNIXTIME(#) <= datetime AND event LIKE \'in_%\''.(qa_opt('user_act_list_max')?' LIMIT '.(int)qa_opt('user_act_list_max'):''),
						qa_get_logged_in_userid(), qa_opt('user_act_list_age'), $last_visit
					)
				);
				if($events) {
					$tooltip = str_replace('#',$events,qa_opt('user_act_list_new_text'));
					
					// pluralizing

					preg_match('/\S+\/\S+/',qa_opt('user_act_list_new_text'),$voicea);
					$voices = explode('/',$voicea[0]);
					foreach ($voices as $voice) {
						if(!preg_match('/[0-9]/',substr($voice,-1))) {
							$tooltip = preg_replace('/\S+\/\S+/',$voice, $tooltip);
							break;
						}
						else if((int)substr($voice,-1) >= $events) {
							$tooltip = preg_replace('/\S+\/\S+/',substr($voice,0,-1),$tooltip);
							break;
						}
					}
					
					$this->content['loggedin']['suffix'] = @$this->content['loggedin']['suffix'].' <a class="qa-history-new-event-link" title="'.$tooltip.'" href="'.qa_path_html('user/'.qa_get_logged_in_handle(), array('tab'=>'history'), qa_opt('site_url')).'"><span class="qa-history-new-event-count">'.$events.'</span></a>';
				}
			}
		}
		if(qa_opt('user_act_list_active') && $this->template == 'user' && (qa_get_logged_in_handle() === $this->_user_handle() || qa_opt('user_act_list_show'))) {
			if(!isset($this->content['navigation']['sub'])) {
				$this->content['navigation']['sub'] = array(
					'profile' => array(
						'url' => qa_path_html('user/'.$this->_user_handle(), null, qa_opt('site_url')),
						'label' => $this->_user_handle(),
						'selected' => !qa_get('tab')?true:false
					),
					'history' => array(
						'url' => qa_path_html('user/'.$this->_user_handle(), array('tab'=>'history'), qa_opt('site_url')),
						'label' => qa_opt('user_act_list_tab'),
						'selected' => qa_get('tab')=='history'?true:false
					),
				);
			}
			else {
				$this->content['navigation']['sub']['history'] = array(
					'url' => qa_path_html('user/'.$this->_user_handle(), array('tab'=>'history'), qa_opt('site_url')),
					'label' => qa_opt('user_act_list_tab'),
					'selected' => qa_get('tab')=='history'?true:false
				);
			}
		}
		qa_html_theme_base::doctype();
	}

	function head_custom() {
		if(($this->template == 'user' || qa_opt('user_act_list_new')) && qa_opt('user_act_list_active')) {
				$this->output('<style>',str_replace('^',QA_HTML_THEME_LAYER_URLTOROOT,qa_opt('user_act_list_css')),'</style>');
		}
		qa_html_theme_base::head_custom();
	}

	function q_list_and_form($q_list)
	{
		if($this->template == 'user' && qa_opt('user_act_list_active') && qa_opt('user_act_list_replace'))
			return;
			
		qa_html_theme_base::q_list_and_form($q_list);
	}

	function main_parts($content)
	{
		if($this->template == 'user' && qa_get('tab')=='history' && qa_opt('event_logger_to_database') && qa_opt('user_act_list_active')) {
			$content = array();
			$content['form-activity-list'] = $this->user_activity_form();  
		}
			

		qa_html_theme_base::main_parts($content);

	}
	
	function user_activity_form() {
		$handle = $this->_user_handle();
		if(!$handle) return;
		$userid = $this->getuserfromhandle($handle);
		if(!$userid) return;
		
		// update last visit
		
		if($userid == qa_get_logged_in_userid() && qa_opt('user_act_list_new')) {
			
			qa_db_query_sub(
				'CREATE TABLE IF NOT EXISTS ^usermeta (
				meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				user_id bigint(20) unsigned NOT NULL,
				meta_key varchar(255) DEFAULT NULL,
				meta_value longtext,
				PRIMARY KEY (meta_id),
				UNIQUE (user_id,meta_key)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8'
			);		

			$last_visit = qa_db_read_one_value(
				qa_db_query_sub(
					'SELECT UNIX_TIMESTAMP(meta_value) FROM ^usermeta WHERE user_id=# AND meta_key=$',
					qa_get_logged_in_userid(), 'visited_profile'
				),
				true
			);

			qa_db_query_sub(
				'INSERT INTO ^usermeta (user_id,meta_key,meta_value) VALUES(#,$,NOW()) ON DUPLICATE KEY UPDATE meta_value=NOW()',
				$userid, 'visited_profile'
			);
		}
		else $last_visit = time();
		
		$events = qa_db_query_sub(
			'SELECT event, BINARY params as params, UNIX_TIMESTAMP(datetime) AS datetime FROM ^eventlog WHERE userid = # AND DATE_SUB(CURDATE(),INTERVAL # DAY) <= datetime ORDER BY datetime DESC'.(qa_opt('user_act_list_max')?' LIMIT '.(int)qa_opt('user_act_list_max'):''),
			$userid, qa_opt('user_act_list_age')
		);

		// no post
		
		$nopost = array(
			'q_delete',
			'a_delete',
			'c_delete',
			'u_password',
			'u_reset',
			'u_save',
			'u_confirmed',
			'u_edit',
			'u_level',
			'u_block',
			'u_unblock',
			'u_register',
			'in_u_edit',
			'in_u_level',
			'in_u_block',
			'in_u_unblock',
			'feedback',
			'search',
		);
		
		// points

		require_once QA_INCLUDE_DIR.'qa-db-points.php';

		$optionnames=qa_db_points_option_names();
		$options=qa_get_options($optionnames);
		$multi = (int)$options['points_multiple'];
		
		// compat fudge
		$upvote = '';
		$downvote = '';
		if($options['points_per_q_voted_up']) {
			$upvote = '_up';
			$downvote = '_down';
		}
		
		$option_events['in_q_vote_up'] = (int)$options['points_per_q_voted'.$upvote]*$multi;
		$option_events['in_q_vote_down'] = (int)$options['points_per_q_voted'.$downvote]*$multi*(-1);
		//$option_events['in_q_vote_nil'] = (int)$options['points_per_q_voted']*$multi;
		$option_events['in_a_vote_up'] = (int)$options['points_per_a_voted'.$upvote]*$multi;
		$option_events['in_a_vote_down'] = (int)$options['points_per_a_voted'.$downvote]*$multi*(-1);
		//$option_events['in_a_vote_nil'] = (int)$options['points_per_a_voted']*$multi;
		$option_events['in_a_select'] = (int)$options['points_a_selected']*$multi;
		$option_events['in_a_unselect'] = (int)$options['points_a_selected']*$multi*(-1);
		$option_events['q_post'] = (int)$options['points_post_q']*$multi;
		$option_events['a_post'] = (int)$options['points_post_a']*$multi;
		$option_events['a_select'] = (int)$options['points_select_a']*$multi;
		$option_events['q_vote_up'] = (int)$options['points_vote_up_q']*$multi;
		$option_events['q_vote_down'] = (int)$options['points_vote_down_q']*$multi;
		$option_events['a_vote_up'] = (int)$options['points_vote_up_a']*$multi;
		$option_events['a_vote_down'] = (int)$options['points_vote_down_a']*$multi;
		
		$fields = array();
		
		while ( ($event=qa_db_read_one_assoc($events,true)) !== null ) {
			$type = $event['event'];
			
			// hide / show exceptions
			
			if(qa_get_logged_in_level()<QA_USER_LEVEL_ADMIN) {
				if($userid != qa_get_logged_in_userid()) { // show public
					$types = explode("\n",qa_opt('user_act_list_show'));
					if(!in_array($type,$types))
						continue;
				}
				else { // hide from owner
					$types = explode("\n",qa_opt('user_act_list_hide'));
					if(in_array($type,$types))
						continue;
				}
			}

			
			if(!qa_opt('user_act_list_'.$type)) continue;
			
			$params = array();
			
			$paramsa = explode("\t",$event['params']);
			foreach($paramsa as $param) {
				$parama = explode('=',$param);
				if(isset($parama[1]))
					$params[$parama[0]]=$parama[1];
				else
					$params[$param]=$param;
			}
			
			$link = '';
			
			if(in_array($type, $nopost)) {
				if($type == 'search') {
					if((int)$params['start'] != 0)
						continue;
					$link = '<a href="'.qa_path_html('search', array('q'=>$params['query'])).'">'.qa_html($params['query']).'</a>';
				}
				else if(in_array($type, array('u_edit','u_level','u_block','u_unblock'))) {
					$ohandle = $this->getHandleFromID($params['userid']);
					$link = '<a href="'.qa_path_html('user/'.$ohandle, null, qa_opt('site_url')).'">'.$ohandle.'</a>';
				}
				else($link = '');
			}
			else if($type == 'badge_awarded') {
				if(!qa_opt('badge_active') || !function_exists('qa_get_badge_type'))
					continue;
				if(isset($params['postid'])) {
					$post = qa_db_read_one_assoc(
						qa_db_query_sub(
							'SELECT type,parentid,BINARY title as title FROM ^posts WHERE postid=#',
							$params['postid']
						),
						true
					);
					
					if(strpos($post['type'],'Q') !== 0) {
						$anchor = qa_anchor((strpos($post['type'],'A') === 0 ?'A':'C'), $params['postid']);
						$parent = qa_db_read_one_assoc(
							qa_db_query_sub(
								'SELECT parentid,type,BINARY title as title,postid FROM ^posts WHERE postid=#',
								$post['parentid']
							),
							true
						);
						if($parent['type'] == 'A') {
							$parent = qa_db_read_one_assoc(
								qa_db_query_sub(
									'SELECT BINARY title as title,postid FROM ^posts WHERE postid=#',
									$parent['parentid']
								),
								true
							);					
						}						
						$activity_url = qa_path_html(qa_q_request($parent['postid'], $parent['title']), null, qa_opt('site_url'),null,$anchor);
						$link = '<a href="'.$activity_url.'">'.$parent['title'].'</a>';									
					}
					else {
						$activity_url = qa_path_html(qa_q_request($params['postid'], $post['title']), null, qa_opt('site_url'),null,$anchor);
						$link = '<a href="'.$activity_url.'">'.$post['title'].'</a>';									
					}
				}
			}
			else if(strpos($event['event'],'q_') !== 0 && strpos($event['event'],'in_q_') !== 0) { // comment or answer
				if(!isset($params['parentid'])) {
					$params['parentid'] = qa_db_read_one_value(
						qa_db_query_sub(
							'SELECT parentid FROM ^posts WHERE postid=#',
							$params['postid']
						),
						true
					);
				}

				$parent = qa_db_select_with_pending(
					qa_db_full_post_selectspec(
						$userid,
						$params['parentid']
					)
				);
				if($parent['type'] == 'A') {
					$parent = qa_db_select_with_pending(
						qa_db_full_post_selectspec(
							$userid,
							$parent['parentid']
						)
					);				
				}
				
				$anchor = qa_anchor((strpos($event['event'],'a_') === 0 || strpos($event['event'],'in_a_') === 0?'A':'C'), $params['postid']);
				$activity_url = qa_path_html(qa_q_request($parent['postid'], $parent['title']), null, qa_opt('site_url'),null,$anchor);
				$link = '<a href="'.$activity_url.'">'.$parent['title'].'</a>';
			}
			else {

				if(!isset($params['title'])) {
					$params['title'] = qa_db_read_one_value(
						qa_db_query_sub(
							'SELECT BINARY title as title FROM ^posts WHERE postid=#',
							$params['postid']
						),
						true
					);
				}
				if($params['title'] !== null) {
					$activity_url = qa_path_html(qa_q_request($params['postid'], $params['title']), null, qa_opt('site_url'));
					$link = '<a href="'.$activity_url.'">'.$params['title'].'</a>';
				}
			}
			
			$time = $event['datetime'];
			
			if(qa_opt('user_act_list_shading')) {
				$days = (qa_opt('db_time')-$time)/60/60/24;
				
				$col = round($days/qa_opt('user_act_list_age')*255/2);
				$bkg = 255-round($days/qa_opt('user_act_list_age')*255/8);
				$bkg = dechex($bkg);
				$col = dechex($col);
				if (strlen($col) == 1) $col = '0'.$col;
				if (strlen($bkg) == 1) $bkg = '0'.$bkg;
				$col = '#' . $col .$col . $col;
				$bkg = '#' . $bkg .$bkg . $bkg;
			}

			$whenhtml=qa_html(qa_time_to_string(qa_opt('db_time')-$time));
			$when = qa_lang_html_sub('main/x_ago', $whenhtml);
			$when = str_replace(' ','<br/>',$when);
			$when = preg_replace('/([0-9]+)/','<span class="qa-history-item-date-no">$1</span>',$when);

			
			$points = @$option_events[$type];
			
			// special points
			
			if(in_array($type,array('in_q_vote_nil','in_a_vote_nil'))) {
				$points = $points*((int)$params['oldvote'] > (int)$params['vote']?-1:1);
			}
			
			$string = qa_opt('user_act_list_'.$type);
			
			if($type == 'badge_awarded') {
				$slug = $params['badge_slug'];
				$typea = qa_get_badge_type_by_slug($slug);
				$types = $typea['slug'];
				$typed = $typea['name'];
				
				$badge_name=qa_badge_lang('badges/'.$slug);
				if(!qa_opt('badge_'.$slug.'_name')) qa_opt('badge_'.$slug.'_name',$badge_name);
				$var = qa_opt('badge_'.$slug.'_var');
				$name = qa_opt('badge_'.$slug.'_name');
				$desc = qa_badge_desc_replace($slug,$var,$name);
				
				$string = str_replace('^badge','<span class="badge-'.$types.'" title="'.$desc.' ('.$typed.')">'.qa_html($name).'</span>',$string);
			}
			
			$fields[] = array(
				'type' => 'static',
				'label'=> '<div class="qa-history-item-date'.(($time >= $last_visit && strpos($type,'in_') === 0)?' qa-history-item-date-new':'').'"'.(qa_opt('user_act_list_shading')?' style="color:'.$col.';background-color:'.$bkg.'"':'').'>'.$when.'</div>',
				'value'=> '<table class="qa-history-item-table"><tr><td class="qa-history-item-type-cell"><div class="qa-history-item-type qa-history-item-'.$type.'">'.$string.'</div></td><td class="qa-history-item-title-cell"><div class="qa-history-item-title">'.$link.'</div></td class="qa-history-item-points-cell"><td align="right">'.($points?'<div class="qa-history-item-points qa-history-item-points-'.($points<0?'neg">':'pos">+').$points.'</div>':'').'</td></tr></table>',
			);
		}		
		
		if(empty($fields)) return;
		
		return array(				
			'style' => 'wide',
			'title' => qa_opt('user_act_list_title'),
			'fields'=>$fields,
		);

	}
	
	// grab the handle of the profile you're looking at
	function _user_handle()
	{
		$handle = preg_replace( '#^user/([^/]+)#', "$1", $this->request );
		return $handle;
	}
	function getuserfromhandle($handle) {
		require_once QA_INCLUDE_DIR.'qa-app-users.php';
		
		if (QA_FINAL_EXTERNAL_USERS) {
			$publictouserid=qa_get_userids_from_public(array($handle));
			$userid=@$publictouserid[$handle];
			
		} 
		else {
			$userid = qa_db_read_one_value(
				qa_db_query_sub(
					'SELECT userid FROM ^users WHERE handle = $',
					$handle
				),
				true
			);
		}
		if (!isset($userid)) return;
		return (int)$userid;
	}
	function getHandleFromID($uid) {
		require_once QA_INCLUDE_DIR.'qa-app-users.php';
		
		if (QA_FINAL_EXTERNAL_USERS) {
			$publictouserid=qa_get_public_from_userids(array($uid));
			$handle=@$publictouserid[$uid];
			
		} 
		else {
			$handle = qa_db_read_one_value(
				qa_db_query_sub(
					'SELECT handle FROM ^users WHERE userid = #',
					$uid
				),
				true
			);
		}
		if (!isset($handle)) return;
		return $handle;
	}
}
