<?php
    /**
     * Calender
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage action
    */
class action
	{
		var $tabela = 'cep_action';
		
	function unassign($d1,$d2)
		{
			
		}
	function assign($d1,$d2)
		{
			$sql = "select * from cep_action_permission where actionp_action = '$d2' and actionp_perfil = '$d1' ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$sql = "update cep_action_permission set actionp_ativa = 1
							where id_actionp = ".$line['id_actionp'];
				} else {
					$sql = "insert cep_action_permission 
								( actionp_action, actionp_perfil, actionp_ativa)
							values
								( '$d2','$d1',1) ";
				}
			$rlt = db_query($sql);			
		}
		
	function perfil_atribui_form()
		{
			global $dd,$acao;
			$b1 = msg('active').' >>';
			$b2 = msg('remove').' <<';
					
			$sql = "select * from cep_action where id_action = ".$dd[0];
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$act_code = $line['action_code'];
				} else {
					return('');
				}
			if (strlen($acao) > 0)
				{
					/* acao */
					if (trim($acao) == $b1)
						{
							$this->assign($dd[1],$act_code);
						}
					if (trim($acao) == $b2)
						{
							$this->unassign($dd[2],$act_code);
						}
				}
			
				
			$sx .= '<table>';
			$sx .= '<TR><TD><form method="post" action="'.page().'">';
			$sx .= '<input type="hidden" name="dd0" value="'.$dd[0].'">';
			$sx .= '<TR valign="center">';
			$sx .= '<TH>'.msg('Denied').'<TH>'.msg('Accept');
			$sx .= '<TR valign="center">';
			$sx .= '<TD>';
			$sx .= '<select size=18 name="dd1" style="width: 400px">';
			$sql = "select * from usuario_perfil
					left join cep_action_permission on actionp_perfil = usp_codigo and actionp_action = '$act_code'
					where usp_ativo = 1 
					order by usp_codigo ";
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
			{
				if (!($line['actionp_ativa']) == '1')
					{
						$cod = $line['usp_codigo'];
						$sel = '';
						$user_name = trim($line['usp_descricao']);
						$sx .= '<option value="'.$cod.'" '.$sel.'>';
						$sx .= trim($user_name);
						$sx .= '</option>';
					}
			}
			$sx .= '</select>';
			$sx .= '<TD>';
			
			$sx .= '<select size=18 name="dd2" style="width: 400px;">';
			$sql = "select * from usuario_perfil
					inner join cep_action_permission on actionp_perfil = usp_codigo 
					where usp_ativo = 1 and actionp_action = '$act_code'
					order by usp_codigo ";
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
			{
				if (($line['actionp_ativa']) == '1')
					{
						$cod = $line['usp_codigo'];
						$sel = '';
						$user_name = trim($line['usp_descricao']);
						$sx .= '<option value="'.$cod.'" '.$sel.'>';
						$sx .= trim($user_name);
						$sx .= '</option>';
					}
			}
			$sx .= '</select>';
			
			$sx .= '<TR>
					<TD>
						<input type="submit" name="acao" value="'.$b1.'">
					<TD>
						<input type="submit" name="acao" value="'.$b2.'">';		
			$sx .= '</table>';
			
			if ((strlen($dd[1]) > 0) and (strlen($dd[2]) > 0))
				{
					$ox = $this->atribui_perfil($dd[1],$dd[2]); 
					if ($ox == 1)
						{
							$sx .= '<center><font color="green">';
							$sx .= '<BR><BR>Seted Perfil';
							$sx .= '<BR><BR>';
						}
					
				}
			return($sx);
		}		
		
		
		function row()
		{
			global $tabela,$http_edit,$http_edit_para,$cdf,$cdm,$masc,$offset,$order;
			$cdf = array('id_action','action_descricao','action_caption','action_code','action_status','action_ativa');
			$cdm = array('ID',msg('description'),msg("action"),msg('code'),msg('status'),msg('active'));
			$masc = array('','','','','','SN','','','','');
			return(True);
		}
	
		function cp()
			{
				global $messa,$dd;
				$cp = array();
				array_push($cp,array('$H8','id_action','',False,True));
				array_push($cp,array('$S60','action_descricao',msg('description'),True,True));
				array_push($cp,array('$S60','action_caption',msg('action_caption'),True,True));				
				array_push($cp,array('$S3','action_code',msg('action_code'),True,True));
				array_push($cp,array('$S1','action_status',msg('status'),True,True));
				array_push($cp,array('$O 1:YES&0:NO','action_ativa',msg('ativo'),False,True));
				
				return($cp);
			}		
		function updatex()
			{
				global $base;
				$c = 'calt';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 3;
				$sql = "update ".$this->tabela_type." set $c2 = lpad($c1,$c3,0) 
						where $c2='' or 1=1";
				if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' "; }
				$rlt = db_query($sql);				
			}			
	}
