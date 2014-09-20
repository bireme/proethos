<?php
    /**
     * Dictamen
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage dictamen
    */
class parecer_avaliation
	{
		var $protocolo;
		var $status;
		var $id;
		
		
		function set_avaliables($id,$req)
			{
				global $messa;
				$link = '<A HREF="#set" onclick="newxy2(';
				$link .= "'protocolo_set_dictamen.php";
				$link .= '?dd0='.$id;
				$link .= '&dd90='.checkpost($id);
				$link .= "',";
				$link .= '300,300);">';
				$link .= '<font class="lt4">';
				$link .= $req;
				$link .= '</font>';
				$link .= '</A>';
				
				$sa = msg('dictamen').'<BR>'.$link.'<BR>'.msg('required');
				return($sa);
			}
		
		function my_dictamen()
			{
			global $ss,$date;
			$proto = $this->protocolo;
			$us = strzero(round($ss->user_id),7);
					
				$sql = "select * from cep_parecer where 
						pp_avaliador = '$us' 
						and pp_protocolo = '$proto'
						and (pp_status = '@' or pp_status = 'A') ";
				
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
					$sa = $this->checklist_form();
					}
		
			return($sa);		
			}
			
		function le($id='')
			{
				$sql = "select * from cep_parecer where id_pp = ".round($id);
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
						$this->protocolo = $line['pp_protocolo'];
						$this->id = $line['id_pp'];
					}
				return(1);
			}
		function mostra()
			{
				global $messa,$ss;
				$sql = "select * from cep_parecer where id_pp = ".round($this->id);
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
					$sx .= '<h2>'.msg('checklist_title').'</h2>';
					$sx .= '<div style="text-align: left;">';
					$sx .= '<font class="lt2">';
					$sx .= '<BR><BR>';
					$sx .= msg('question_1');
					$sx .= '<BR><I><font color="blue">'.$line['pp_abe_01'].'</font></I>';
					$sx .= '<BR><BR>';
					$sx .= msg('question_2');
					$sx .= '<BR><I><font color="blue">'.$line['pp_abe_02'].'</font></I>';
					$sx .= '<BR><BR>';
					$sx .= msg('question_3');
					$sx .= '<BR><I><font color="blue">'.$line['pp_abe_03'].'</font></I>';
					$sx .= '<BR><BR>';
					$sx .= msg('question_4');
					$sx .= '<BR><I><font color="blue">'.$line['pp_abe_04'].'</font></I>';
					$sx .= '<BR><BR>';
					$sx .= msg('question_5');
					$sx .= '<BR><I><font color="blue">'.$line['pp_abe_05'].'</font></I>';
					$sx .= '<BR><BR>';
					$sx .= msg('question_6');
					$sx .= '<BR><I><font color="blue">'.$line['pp_abe_06'].'</font></I>';
					$sx .= '<BR><BR>';
					$sx .= '</div>';
					$sx .= '<BR><BR>';
					}
				return($sx);
			}
		function checklist_form()
			{
				global $dd,$acao,$messa,$ss;
				$proto = $this->protocolo;
				
				$us = strzero(round($ss->user_id),7);
				if (strlen($acao) == 0)
					{
						$sql = "select * from cep_parecer 
								where pp_avaliador = '$us' 
								and pp_protocolo = '$proto' "; 
						$rrr = db_query($sql);
						if ($line = db_read($rrr))
							{
								$dd[20] = trim($line['pp_abe_01']);
								$dd[21] = trim($line['pp_abe_02']);
								$dd[22] = trim($line['pp_abe_03']);
								$dd[23] = trim($line['pp_abe_04']);
								$dd[24] = trim($line['pp_abe_05']);
								$dd[25] = trim($line['pp_abe_06']);
							}
						
						
					}
								
				$sa .= '<div style="text-align: left; padding 5px 5px 5px 5px; width: 95%;">';
				$sa .= '<a name="par">';
				$sa .= '<form method="post" action="'.page().'#par">';
				$sa .= '<input type="hidden" name="dd1" value="'.$dd[1].'">';
				$sa .= '<input type="hidden" name="dd2" value="'.$dd[2].'">';
				$sa .= '<input type="hidden" name="dd3" value="'.$dd[3].'">';
				$sa .= '<input type="hidden" name="dd90" value="'.$dd[90].'">';
				$sa .= '<h2>'.msg('checklist_title').'</h2>';
				/** Save */
				if (strlen($acao) > 0)
					{
						$err = '';
						if (strlen($dd[20]) == 0) { $err .= msg('question_error').' #1<BR>'; }
						if (strlen($dd[21]) == 0) { $err .= msg('question_error').' #2<BR>'; }
						if (strlen($dd[22]) == 0) { $err .= msg('question_error').' #3<BR>'; }
						if (strlen($dd[23]) == 0) { $err .= msg('question_error').' #4<BR>'; }
						if (strlen($dd[24]) == 0) { $err .= msg('question_error').' #5<BR>'; }
						if (strlen($dd[25]) == 0) { $err .= msg('question_error').' #6<BR>'; }
						if (strlen($err) > 0)
							{
								$sa .= '<center><div style="background-color: #FFC0C0; width:90%; padding: 5px 5px 5px 5px;">'.$err.'</div></center>';
							} 
						$sql = "update cep_parecer set 
								pp_abe_01 = '".$dd[20]."',
								pp_abe_02 = '".$dd[21]."',
								pp_abe_03 = '".$dd[22]."',
								pp_abe_04 = '".$dd[23]."',
								pp_abe_05 = '".$dd[24]."',
								pp_abe_06 = '".$dd[25]."',
								pp_parecer_data = '".date("Ymd")."',
								pp_parecer_hora = '".date("H:i")."' ";
						if ((strlen($err)==0) and ($dd[29]=='1'))
							{ $sql .= ", pp_status = 'B' "; } else 
							{ $sql .= ", pp_status = 'A' "; }
						$sql .= " where pp_avaliador = '$us' 
								and pp_protocolo = '$proto' ";
						
						$rrr = db_query($sql);
						if ((strlen($err)==0) and ($dd[29]=='1'))
							{
								redirecina('protocolo_detalhe.php?dd90='.$dd[90].'&dd91=');
							}
					}
				$sa .= '<BR>'.msg('question_1').'<BR>';
				$sa .= '<textarea name="dd20" cols=80 rows=5 style="width:100%">'.$dd[20].'</textarea>';
				$sa .= '<BR><BR>'.msg('question_2').'<BR>';
				$sa .= '<textarea name="dd21" cols=80 rows=5 style="width:100%">'.$dd[21].'</textarea>';
				$sa .= '<BR><BR>'.msg('question_3').'<BR>';
				$sa .= '<textarea name="dd22" cols=80 rows=5 style="width:100%">'.$dd[22].'</textarea>';
				$sa .= '<BR><BR>'.msg('question_4').'<BR>';
				$sa .= '<textarea name="dd23" cols=80 rows=5 style="width:100%">'.$dd[23].'</textarea>';
				$sa .= '<BR><BR>'.msg('question_5').'<BR>';
				$sa .= '<textarea name="dd24" cols=80 rows=5 style="width:100%">'.$dd[24].'</textarea>';
				$sa .= '<BR><BR>'.msg('question_6').'<BR>';
				$sa .= '<textarea name="dd25" cols=80 rows=5 style="width:100%">'.$dd[25].'</textarea>';
				$sa .= '<BR><BR>';
				$sa .= '<input type="checkbox" name="dd29" value="1">'.msg('definitive_version');
				$sa .= '<BR><BR>';
				$sa .= '<input type="submit" name="acao" value="'.msg('check_list_save').'">';
				$sa .= '</form>';
				$sa .= '</div>';
				return($sa);
			}
		function resume()
			{
			global $user,$date,$nw;
			$proto = $this->protocolo;
						
			$sql = "select * from usuario 
					inner join cep_parecer on (us_codigo = pp_avaliador and pp_protocolo = '$proto' )
					left join institutions on it_codigo = us_empresa ";
			$rlt = db_query($sql);
			$sel = 0;
			$sx .= '<A name="res"></A>';
			while ($line = db_read($rlt))
				{
					$sel++;			
					$sx .= '<TRclass="lt0">';
					$sx .= '<TD>';
					$sx .= $line['us_nome'];
					$sx .= '<TD>';
					$sx .= $line['it_nome'];
					$sx .= '<TD>';
					$sx .= $line['us_email'];
					$sx .= '<TD align="center">';
					$data = $line['pp_data'];
					if ($data > 20000101) { $data = $date->stod($data); } else { $data = '';}
					$sx .= $data;
					
					/* Link */
					$link = '<A HREF="#res" onclick="newxy2(';
					$link .= "'parecer_checklist_see.php?dd0=".$line['id_pp'].'&dd90='.checkpost($line['id_pp'])."'";
					$link .= ',750,500);">';
					/* Status */
					$sx .= '<TD align="center">';
					$pp_status = $line['pp_status'];
					if ($pp_status == '@') { $sx .= msg('indicated'); }
					if ($pp_status == 'A') { $sx .= msg('analysing'); }
					if ($pp_status == 'B') { $sx .= $link.'<B>'.msg('available').'</B></A>'; }
					if ($pp_status == 'X') { $sx .= msg('canceled'); }
				}		
			if ($sel == 0) 
				{ $sx .= '<TR><TD colspan=5 align=center><BR>'.msg('no_indications'); }
				
			$sa .= '<table width="100%" class="lt0">';
			$sa .= '<TR bgcolor="#E0E0FF" align="center"><TH>'.msg('name');
			$sa .= '<TH>'.msg('instituion');
			$sa .= '<th>e-mail<TH>'.msg('indicate_data');
			$sa .= '<TH>'.msg('indicate_status');
			$sa .= $sx;
			
			$sa .= '</table>';
			
			return($sa);
			}
			
	function indicate_avaliator()
		{
			global $dd,$acao,$_POST,$date;
			$proto = $this->protocolo;
			print_r($_POST);
			$sql = "select * from usuario 
					left join cep_parecer on (us_codigo = pp_avaliador and pp_protocolo = '$proto' )
					left join institutions on it_codigo = us_empresa
					where us_ativo = 1 ";

			$rlt = db_query($sql);
			$sel = 0;
			$sql = array();
			while ($line = db_read($rlt))
				{
					$id = $line['id_us'];
					$ddx = $_POST['dda'.$id];
					$dds = '';
					if (strlen($ddx) > 0)
						{
							$data = date("Ymd");
							$hora = date("H:i");
							$avaliador = $line['us_codigo'];
							$dds = 'checked' ; $sel++; 
							$sql = "select * from cep_parecer 
										where pp_avaliador = '$avaliador' and
										pp_protocolo = '$proto' ";
							$rrlt = db_query($sql);
							if (!($rline = db_read($rrlt)))
								{
								$this->cep_historic_append('010',msg('indicate_avaliation_to').' '.$line['us_nome']);
								/** Indicate new avaliation */
								$sql = "insert into cep_parecer 
									( pp_nrparecer, pp_tipo, pp_protocolo,
									  pp_protocolo_mae, pp_avaliador, pp_revisor,
									  pp_status, pp_pontos, pp_pontos_pp,
									  pp_data, pp_hora, pp_parecer_data, pp_parecer_hora, 
									  pp_data_leitura 
									) values (
									 '','PAREC','$proto',
									 '','$avaliador','$revisor',
									 '@',0,0,
									 $data,'$hora',19000101,'00:00',
									 19000101)";
									 $xrlt = db_query($sql);
								} else {
								$this->cep_historic_append('011',msg('renew_avaliation_to').' '.$line['us_nome']);
								/* Renew avaliation */
									$sql = "update cep_parecer 
											set pp_status = '@',
											pp_data = $data,
											pp_hora = '$hora'
											where pp_avaliador = '$avaliador' and
										pp_protocolo = '$proto' ";
										$xrlt = db_query($sql);
								}								
						}
						
										
					$sx .= '<TR>';
					$sx .= '<TD width="5">';
					$sx .= '<input type="checkbox" name="dda'.$id.'" value=1 '.$dds.'>';
					$sx .= '<TD>';
					$sx .= $line['us_nome'];
					$sx .= '<TD>';
					$sx .= $line['it_nome'];
					$sx .= '<TD>';
					$sx .= $line['us_email'];
					$sx .= '<TD align="center">';
					$data = $line['pp_data'];
					if ($data > 20000101) { $data = $date->stod($data); } else { $data = '';}
					$sx .= $data;
					
					/* Status */
					$sx .= '<TD align="center">';
					$pp_status = $line['pp_status'];
					$sx .= '--';
					if (strlen($pp_status) > 0)
						{
							if ($pp_status == '@') { $sx .= msg('indicated'); }
							if ($pp_status == 'A') { $sx .= msg('analysing'); }
							if ($pp_status == 'B') { $sx .= msg('available'); }
							if ($pp_status == 'X') { $sx .= msg('canceled'); }
						} else {
							$sx .= '-';
						}
					}
			/** alter status */
			if ($sel > 0)
				{ $this->cep_status_alter('B'); }
			$sa = '<table width="100%" class="lt1">';
			$sa .= '<TR><TD><form method="post" action="'.page().'">';
			$sa .= '<TR><TD>
				<input type="hidden" name="dd1" value="'.$dd[1].'">
				<input type="hidden" name="dd2" value="'.$dd[2].'">
				<input type="hidden" name="dd3" value="'.$dd[3].'">
				<input type="hidden" name="dd90" value="'.$dd[90].'">
				';
			
			
			$sa .= '<TR bgcolor="#808080"><TH>sel<TH>'.msg('name');
			$sa .= '<TH>'.msg('instituion');
			$sa .= '<th>e-mail<TH>'.msg('indicate_data');
			$sa .= '<TH>'.msg('indicate_status');
			$sa .= $sx;
			$sa .= '<TR><TD colspan=5><input type="submit" value="'.msg('define_evaluator_btn').'" name="dd6">';
			$sa .= '<TR><TD></form>';
			$sa .= '</table>';
			//$this->cep_historic_append($ac,msg('protocol_accept'));
			//$this->cep_status_alter('A'); 
			echo $sa;
			return(1);
		}

	}
?>
