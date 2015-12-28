<?php
// This file is part of the ProEthos Software.
//
// Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
// ProEthos under the terms of the ProEthos License as published by PAHO, which
// restricts commercial use of the Software.
//
// ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details.
//
// You should have received a copy of the ProEthos License along with the ProEthos
// Software. If not, see
// https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt

class update_system {
	function update01() {
		$sql = "select * from cep_action_permission 
							where actionp_action = '015'
							and actionp_perfil = '#MEM'
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 001');
		} else {
			$sql = " insert into cep_action_permission 
							( actionp_action, actionp_perfil, actionp_ativa ) 
						values 
							( '015','#MEM',1 )";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 001 ' . msg('successful');
		}
	}

	function update02() {
		$sql = "SHOW COLUMNS FROM cep_protocolos where Field = 'cep_caae_original'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 002');
		} else {
			$sql = "ALTER TABLE cep_protocolos 
								ADD cep_caae_original CHAR(30) 
								NOT NULL AFTER cep_caae;";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 002 ' . msg('successful');
		}
	}

	function update03() {
		$sql = "SHOW COLUMNS FROM _messages where Field = 'msg_pag' and Type like 'text%'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 003');
		} else {
			$sql = "ALTER TABLE _messages MODIFY msg_pag text;";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 003 ' . msg('successful');
		}
	}

	function update04() {
		$sql = "select * from cep_amendment_type 
							where amt_ativo = 1
							and id_amt = 1
					";
		$rlt = db_query($sql);
		if (!($line = db_read($rlt))) {
			echo '<br>' . msg('already update - 004');
		} else {
			$sql = "update cep_amendment_type set amt_ativo = 0 where id_amt = 1";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 004 ' . msg('successful');
		}
	}

	function update05() {
		$sql = "SHOW COLUMNS FROM cep_protocolos where Field = 'cep_recrutamento_status'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 005');
		} else {
			$sql = "ALTER TABLE cep_protocolos 
								ADD cep_recrutamento_status CHAR(40) 
								NOT NULL AFTER cep_recrutamento";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 005 ' . msg('successful');
		}
	}

	function update06() {
		/***********/
		$sql = "select * from cep_action 
							where action_code = '020'
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 006A');
		} else {
			$sql = "INSERT cep_action 
								(action_status, action_descricao, action_caption,
								action_ativa, action_code, action_color)
								values
								('D','upload_draft_opinion','upload_draft_opinion',
								1,'020','#000000')";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 006A ' . msg('successful');
		}
		/***********/
		$sql = "select * from cep_action_permission 
							where actionp_action = '020'
							and actionp_perfil = '#SCR'
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 006B');
		} else {
			$sql = "INSERT cep_action_permission 
								(actionp_action, actionp_perfil)
								values
								('020','#SCR')";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 006B ' . msg('successful');
		}
		/***********/
		$sql = "select * from cep_action_permission 
							where actionp_action = '020'
							and actionp_perfil = '#ADM'
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 006C');
		} else {
			$sql = "INSERT cep_action_permission 
								(actionp_action, actionp_perfil)
								values
								('020','#ADM')";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 006C ' . msg('successful');
		}

		/***************/

		$sql = "select * from cep_ged_documento_tipo 
							where doct_codigo = 'DICTM'
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 006D');
		} else {
			$sql = "INSERT cep_ged_documento_tipo 
								(doct_codigo, doct_nome,doct_publico,
								doct_avaliador, doct_autor, doct_restrito,
								doct_ativo)
								values
								('DICTM','Opinión interina',1,
								0,1,0,
								1
								)";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 006D ' . msg('successful');
		}
	}

	function update07() {
		/***********/
		$sql = "select * from cep_action 
							where action_code = '021'
							and action_descricao = 'send_to_secretary'
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 007A');
		} else {
			/* remove other registers */
			$sql = "DELETE FROM cep_action where action_code = '021' ";
			$rlt = db_query($sql);

			/* inser new register */
			$sql = "INSERT cep_action 
								(action_status, action_descricao, action_caption,
								action_ativa, action_code, action_color)
								values
								('D','send_to_secretary','send_to_secretary',
								1,'021','#000000')";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 007A ' . msg('successful');
		}
		/***********/
		$sql = "select * from cep_action_permission 
							where actionp_action = '021'
							and actionp_perfil = '#SCR'
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 007B');
		} else {
			$sql = "INSERT cep_action_permission 
								(actionp_action, actionp_perfil)
								values
								('021','#SCR')";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 006B ' . msg('successful');
		}
		/***********/
		$sql = "select * from cep_action_permission 
							where actionp_action = '021'
							and actionp_perfil = '#ADM'
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			echo '<br>' . msg('already update - 007C');
		} else {
			$sql = "INSERT cep_action_permission 
								(actionp_action, actionp_perfil)
								values
								('021','#ADM')";
			$rlt = db_query($sql);
			echo '<br>' . msg('update') . ' 007C ' . msg('successful');
		}
	}

	function update08() {
		$up = 0;
		$filename = "_documents/ged_download_ic.php.xml";

		$xml = "";
		$f = fopen($filename, 'r');
		while ($data = fread($f, 4096)) { $xml .= $data;
		}
		fclose($f);

		preg_match_all("/\<ic\>(.*?)\<\/ic\>/s", $xml, $bookblocks);

		foreach ($bookblocks[1] as $block) {
			//$block = utf8_encode($block);
			$block = troca($block, '[e]', '&');
			preg_match_all("/\<nw_idioma\>(.*?)\<\/nw_idioma\>/", $block, $idioma);
			preg_match_all("/\<nw_dt_cadastro\>(.*?)\<\/nw_dt_cadastro\>/", $block, $author);
			preg_match_all("/\<nw_titulo\>(.*?)\<\/nw_titulo\>/", $block, $title);
			$sc = '<nw_descricao>';
			$txt = substr($block, strpos($block, $sc) + strlen($sc));
			$sc = '</nw_descricao>';
			$txt = substr($txt, 0, strpos($txt, $sc));

			preg_match_all("/\<nw_ref\>(.*?)\<\/nw_ref\>/", $block, $ref);

			$ref = $ref[1][0];
			$cadastro = $author[1][0];
			$titulo = $title[1][0];
			$idioma = $idioma[1][0];

			$sql = "select * from ic_noticia where nw_ref = '$ref' and nw_idioma = '$idioma' ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt)) {
				if (($line['nw_dt_cadastro'] == $cadastro) and ($line['nw_descricao'] != $txt)) {
					$sql = "update ic_noticia set 
										nw_titulo = '$titulo',
										nw_descricao = '$txt',
										nw_dt_cadastro = '$cadastro'
									where id_nw = " . $line['id_nw'];
					$rlt = db_query($sql);
					$up++;
					echo '<br>'.$sql;
				}
			} else {
				$sql = "insert into ic_noticia 
							(
							nw_dt_cadastro, nw_secao, nw_link,
							nw_fonte, nw_titulo, nw_descricao, 
							nw_dt_de, nw_dt_ate, 	nw_log,
							
							nw_ativo, 	nw_ref, nw_thema,
							nw_idioma, nw_journal, journal_id
							
							) values (
							'$cadastro',1,'',
							'','$titulo','$txt',
							'19000101','19000101','',
							
							1,'$ref','',
							'$idioma',0,0)	
							";
				$rlt = db_query($sql);
				//echo '<br>'.$sql;
				$up++;
			}
		}
		if ($up > 0) {
			echo '<br>' . msg('update') . ' 008 ' . msg('successful');
		} else {
			echo '<br>' . msg('already update - 008');
		}
	}

	function update09() {
		$up = 0;
		$sql = "select * from (
			select count(*) as total, min(id_msg) as m, msg_language, msg_field
				FROM _messages
				GROUP BY msg_language, msg_field
		) as tabela where total > 1";
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) {
			$lang = $line['msg_language'];
			$fld = $line['msg_field'];
			$id = $line['m'];
			$sql = "delete from _messages where msg_language = '$lang' and msg_field = '$fld' and id_msg <> $id ";
			$xrlt = db_query($sql);
			//echo '<br>'.$sql;
			$up++;
		}
		if ($up > 0) {
			echo '<br>' . msg('update') . ' 009 ' . msg('successful');
		} else {
			echo '<br>' . msg('already update - 009');
		}
	}

	function update10() {
		$up = 0;
		$new = 0;
		$filename = "_documents/ged_download_msg.php.xml";

		$xml = "";
		$f = fopen($filename, 'r');
		while ($data = fread($f, 4096)) { $xml .= $data;
		}
		fclose($f);

		preg_match_all("/\<reg\>(.*?)\<\/reg\>/s", $xml, $bookblocks);

		foreach ($bookblocks[1] as $block) {
			//$block = utf8_encode($block);
			$block = troca($block, '[e]', '&');
			preg_match_all("/\<msg_language\>(.*?)\<\/msg_language\>/", $block, $idioma);
			preg_match_all("/\<msg_field\>(.*?)\<\/msg_field\>/", $block, $field);
			preg_match_all("/\<msg_content\>(.*?)\<\/msg_content\>/", $block, $content);

			$ref = $field[1][0];
			$content = $content[1][0];
			$idioma = $idioma[1][0];
			$data = date("Ymd");

			$sql = "select * from _messages where msg_field = '$ref' and msg_language = '$idioma' ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt)) {
				if ($line['msg_content'] != $content) {
					$sql = "update _messages set 
										msg_content = '$content',
										msg_update = '$data'
									where id_msg = " . $line['id_msg'];
					$rlt = db_query($sql);
					$up++;
					//echo '<br>' . $ref.'-'.$idioma.'-'.$sql;
				}

			} else {
				$sql = "insert into _messages 
							(
							msg_pag, msg_language, msg_content,
							msg_ativo, msg_update, msg_field
							) values (
							'','$idioma','$content',
							1,$data,'$ref'
							)	
							";
				$rlt = db_query($sql);
				$new++;

			}
		}
		if (($up + $new) > 0) {
			echo '<br>' . msg('update') . ' 010 ' . msg('successful') . ' ' . $new . '/' . $up . ' updated';
		} else {
			echo '<br>' . msg('already update - 010');
		}
	}

	function lista_arquivos() {
		/* Update 2015-10-14 */
		$this -> update01();
		$this -> update02();
		$this -> update03();
		$this -> update04();
		$this -> update05();
		$this -> update06();
		$this -> update07();
		$this -> update08();
		$this -> update09();
		$this -> update10();
		/* Update 2015-10-15 */
		return ('');
	}

}
?>