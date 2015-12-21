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
	function update01()
		{
			$sql = "select * from cep_action_permission 
							where actionp_action = '015'
							and actionp_perfil = '#MEM'
					";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 001');
				} else {
					$sql = " insert into cep_action_permission 
							( actionp_action, actionp_perfil, actionp_ativa ) 
						values 
							( '015','#MEM',1 )";
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 001 '.msg('successful');					
				}
		}
	function update02()
		{
			$sql = "SHOW COLUMNS FROM cep_protocolos where Field = 'cep_caae_original'";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 002');
				} else {
					$sql = "ALTER TABLE cep_protocolos 
								ADD cep_caae_original CHAR(30) 
								NOT NULL AFTER cep_caae;";
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 002 '.msg('successful');					
				}
		}
	function update03()
		{
			$sql = "SHOW COLUMNS FROM _messages where Field = 'msg_pag' and Type like 'text%'";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 003');
				} else {
					$sql = "ALTER TABLE _messages MODIFY msg_pag text;";
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 003 '.msg('successful');					
				}			
		}	
	function update04()
		{
			$sql = "select * from cep_amendment_type 
							where amt_ativo = 1
							and id_amt = 1
					";
			$rlt = db_query($sql);
			if (!($line = db_read($rlt)))
				{
					echo '<br>'.msg('already update - 004');
				} else {
					$sql = "update cep_amendment_type set amt_ativo = 0 where id_amt = 1";	
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 004 '.msg('successful');					
				}
		}	
	function update05()
		{
			$sql = "SHOW COLUMNS FROM cep_protocolos where Field = 'cep_recrutamento_status'";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 005');
				} else {
					$sql = "ALTER TABLE cep_protocolos 
								ADD cep_recrutamento_status CHAR(40) 
								NOT NULL AFTER cep_recrutamento";
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 005 '.msg('successful');					
				}			
		}			
	function update06()
		{
			/***********/
			$sql = "select * from cep_action 
							where action_code = '020'
					";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 006A');
				} else {
					$sql = "INSERT cep_action 
								(action_status, action_descricao, action_caption,
								action_ativa, action_code, action_color)
								values
								('D','upload_draft_opinion','upload_draft_opinion',
								1,'020','#000000')";	
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 006A '.msg('successful');					
				}	
			/***********/				
			$sql = "select * from cep_action_permission 
							where actionp_action = '020'
							and actionp_perfil = '#SCR'
					";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 006B');
				} else {
					$sql = "INSERT cep_action_permission 
								(actionp_action, actionp_perfil)
								values
								('020','#SCR')";	
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 006B '.msg('successful');					
				}
			/***********/
			$sql = "select * from cep_action_permission 
							where actionp_action = '020'
							and actionp_perfil = '#ADM'
					";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 006C');
				} else {
					$sql = "INSERT cep_action_permission 
								(actionp_action, actionp_perfil)
								values
								('020','#ADM')";	
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 006C '.msg('successful');					
				}	
				
			/***************/
			
			$sql = "select * from cep_ged_documento_tipo 
							where doct_codigo = 'DICTM'
					";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 006D');
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
					echo '<br>'.msg('update').' 006D '.msg('successful');					
				}						
		}	
	function update07()
		{
			/***********/
			$sql = "select * from cep_action 
							where action_code = '021'
							and action_descricao = 'send_to_secretary'
					";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 007A');
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
					echo '<br>'.msg('update').' 007A '.msg('successful');					
				}	
			/***********/				
			$sql = "select * from cep_action_permission 
							where actionp_action = '021'
							and actionp_perfil = '#SCR'
					";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 007B');
				} else {
					$sql = "INSERT cep_action_permission 
								(actionp_action, actionp_perfil)
								values
								('021','#SCR')";	
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 006B '.msg('successful');					
				}
			/***********/
			$sql = "select * from cep_action_permission 
							where actionp_action = '021'
							and actionp_perfil = '#ADM'
					";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					echo '<br>'.msg('already update - 007C');
				} else {
					$sql = "INSERT cep_action_permission 
								(actionp_action, actionp_perfil)
								values
								('021','#ADM')";	
					$rlt = db_query($sql);
					echo '<br>'.msg('update').' 007C '.msg('successful');					
				}		
		}	
	
	function lista_arquivos() {
		/* Update 2015-10-14 */
		$this->update01();
		$this->update02();
		$this->update03();
		$this->update04();
		$this->update05();
		$this->update06();
		$this->update07();
		
		
		/* Update 2015-10-15 */
		return('');
	}

}
?>