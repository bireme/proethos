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


 /**
  * Resume
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.14.04
  * @package Class
  * @subpackage resume
 */
class resume
	{
		var $pesquisador;
		
		function calender()
			{
				$cal = new calendar;
				$sx = '<h1>'.msg("calender").'</h1>';
				$sx .= '<table width="100%" class="lt1" border=0>';
	
				$data1 = date("Ym");
				if (date("m")==12) {
					$data2 = (date("Y")+1).'01'; 
				} else {
					$data2 = (date("Ym")+1);
				}
				/* Actual Month */
				$act1 = $cal->actions($data1);
				$sx .= '<TR valign="top">';
				$sx .= '<TD width="10%">';
				$sx .= '<center><font class="lt1"><B>'.msg('month_'.substr($data1,4,2)).'/'.substr($data1,0,4).'</B></font>';
				$sx .= $cal->calendar($data1,$act1,'#1C4161');
				$sx .= '<TD width="90%">';
				$sx .= $cal->actions_list($act1);
				/* Space */
				$sx .= '<TR valign="top">';
				$sx .= '<TD width="10%">&nbsp;';
				
				/* Next Month */
				$act2 = $cal->actions($data2);
				$sx .= '<TR valign="top">';
				$sx .= '<TD width="10%">';
				$sx .= '<center><font class="lt1"><B>'.msg('month_'.substr($data2,4,2)).'/'.substr($data2,0,4).'</B></font>';
				$sx .= $cal->calendar($data2,$act2,'#1C4161');
				$sx .= '<TD width="90%">';
				$sx .= $cal->actions_list($act2);	
				$sx .= '</table>';			
				return($sx);				
			}
		
		function resume()
			{
				global $tab_max,$message,$nw,$ss;

						$sql = "
						select count(*) as total, doc_status from cep_submit_documento where doc_status <> 'X'
						and doc_autor_principal  = '".$ss->user_codigo."' group by doc_status
						
						union 
						
						select count(*) as total, cep_status as doc_status from cep_protocolos 
							where cep_status = 'P' and cep_pesquisador = '".$ss->user_codigo."' and cep_tipo = 'PRO'
							group by cep_status
							 
				";
				$rlt = db_query($sql);
				$tp = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
				while ($line = db_read($rlt))
					{
						$total = round($line['total']);
						$sta = trim($line['doc_status']);
						/* Protocolos devolvidos para correção */
						if ($sta == '$') { $tp[9] = $tp[9] + $total; }
						if ($sta == '@') { $tp[0] = $tp[0] + $total; }
						if ($sta == 'A') { $tp[1] = $tp[1] + $total; }
						if ($sta == 'B') { $tp[2] = $tp[2] + $total; }
						if ($sta == 'C') { $tp[3] = $tp[3] + $total; }
						if ($sta == 'D') { $tp[3] = $tp[3] + $total; }
						if ($sta == 'E') { $tp[3] = $tp[3] + $total; }
						if ($sta == 'P') { $tp[4] = $tp[4] + $total; }
						if ($sta == 'H') { $tp[2] = $tp[2] + $total; }
						/* Protocolo Aprovado com recomendacao */
						if ($sta == 'Z') { $tp[9] = $tp[9] + $total; }
						
					}
				
				$sx .= '<h1>'.msg('resume').'</h1>';
				//$sx .=  '<Table width="'.$tab_max.'" class="table_resume" align="center" >';
				//$sx .=  '<TR><TD>';
				//$sx .=  '<fieldset><legend>'.msg('research').'</legend>';
				$sx .=  '<Table width="100%" class="table_resume" border=1 >';
				
				$sz = '20%';
				if (($tp[9]+$tp[10]) > 0)
					{
						$sz = (round(100 / 6)-1).'%';
					}
				/* Protocolo em Submissao */
				$sx .= '<TR class="table_resume_th" align="center"> ';
				$sx .= '<TH width="'.$sz.'" align="center">'.msg('prot_in_submission');
				if (($tp[9] + $tp[10])> 0)
					{
						$sx .= '<TH width="'.$sz.'" align="center" bgcolor="#FFC0C0">'.msg('prot_problem');
					}
				$sx .= '<TH width="'.$sz.'%" align="center">'.msg('prot_submitted');
				$sx .= '<TH width="'.$sz.'%" align="center">'.msg('prot_in_analysis');
				$sx .= '<TH width="'.$sz.'%" align="center">'.msg('prot_rejected');
				$sx .= '<TH width="'.$sz.'%" align="center">'.msg('prot_aproved');
				
				if ($tp[9] > 0) { $link[9] = '<A HREF="research_list.php?dd2='.md5(date("Ymd")).'&dd1=problem" class="table_resume_td">'; }				
				if ($tp[0] > 0) { $link[0] = '<A HREF="research.php?dd1=@" class="table_resume_td">'; }
				if ($tp[1] > 0) { $link[1] = '<A HREF="research.php?dd1=A" class="table_resume_td">'; }
				if ($tp[2] > 0) { $link[2] = '<A HREF="research.php?dd1=B" class="table_resume_td">'; }
				if ($tp[3] > 0) { $link[3] = '<A HREF="research.php?dd1=C" class="table_resume_td">'; }
				if ($tp[4] > 0) { $link[4] = '<A HREF="research.php?dd1=P" class="table_resume_td">'; }
				
				$sx .= '<TR class="table_resume_td">';
				$sx .= '<TD align="center">'.$link[0].round($tp[0]).'</A>';
				if ($tp[9] > 0)
					{
					$sx .= '<TD align="center" bgcolor="#FFC0C0">'.$link[9].round($tp[9]).'</A>';
					}

				$sx .= '<TD align="center">'.$link[1].round($tp[1]).'</A>';
				$sx .= '<TD align="center">'.$link[2].round($tp[2]).'</A>';
				$sx .= '<TD align="center">'.$link[3].round($tp[3]).'</A>';
				$sx .= '<TD align="center">'.$link[4].round($tp[4]).'</A>';
				
				$sx .= '</table>';
				
				/* CEP */
				
				$sx .=  '<Table width="100%" class="lt1" align="center" border=0 >';
				$sx .= '<TR><TD>';
				$sx .= '<form action="submit.php">';
				$sx .= '<input type="submit" value="'.strip_tags(msg('submit_new_project')).'" class="form_submit">';	
				$sx .= '<input type="hidden" name="dd90" value="new">';
				$sx .= '</form>';
				$sx .= '</table>';
				//$sx .= '</fieldset>';

				return($sx);
			}

		function resume_cep()
			{
			global $tab_max,$message,$ss,$perfil;
			$tp = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			$us = strzero(round($ss->user_id),7);				
					
			/* Troca PP por PR */
			$sql = "select count(*) as total from cep_dictamen 
					inner join cep_protocolos on pp_protocolo = cep_protocol
					where 
					 (cep_status = '@' or cep_status = 'A' or cep_status = 'B' or cep_status = 'C' or cep_status = 'D')
					 and pp_avaliador = '$us' 
					 and (pp_status <> 'B' and pp_status <> 'X') 
					";
					
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
				{
					$tp[9] = $line['total'];
				}
			

			$sql = "select count(*) as total, cep_status, cep_tipo  
						from cep_protocolos
						where (cep_status <> 'X' and cep_status <> '@') 
						group by cep_status, cep_tipo
				";
				
				$rlt = db_query($sql);	
				
				while ($line = db_read($rlt))
					{
						$total = round($line['total']);
						$tipo = trim($line['cep_tipo']);
						$sta = $line['cep_status'];
						if ($sta == '@') { $tp[0] = $tp[0] + $total; }
						if ($sta == 'A') { $tp[1] = $tp[1] + $total; }
						if ($sta == 'B') { $tp[2] = $tp[2] + $total; }
						if ($sta == 'C') { $tp[3] = $tp[3] + $total; }
						if ($sta == 'D') { $tp[4] = $tp[4] + $total; }
						if ($sta == 'H') { $tp[5] = $tp[5] + $total; }
						if ($sta == 'E') { $tp[6] = $tp[6] + $total; }
						if (($sta == 'P') and ($tipo == 'PRO')) { $tp[7] = $tp[7] + $total; }	
					}
				
				$sx .= '<h1>'.msg('resume_committee').'</h1>';
				//$sx .=  '<Table width="100%" class="table_resume" align="center" >';
				//$sx .=  '<TR><TD>';
				//$sx .=  '<fieldset><legend>'.msg('research').'</legend>';
				$sx .=  '<Table width="100%" class="table_resume" border=1 >';
				/* Protocolo em Submissao */
				
				$size = 15;
				$sx .= '<TR  class="table_resume_th" align="center"> ';
				if ($perfil->valid("#SCR#COO#ADM"))
					{ $sx .= '<TH width="'.$size.'%" align="center">'.msg('subm_to_accept'); }
				if ($tp[5] > 0)
					{ $sx .= '<TD width="'.$size.'%" align="center"  class="table_resume_td_sel"><B>'.msg('pesq_check'); }
				if (($tp[6] > 0) and ($perfil->valid("#SCR#COO#ADM")))
					{ $sx .= '<TD width="'.$size.'%" align="center"  class="table_resume_td_sel"><B>'.msg('secretaty_revision'); }
				if ($tp[9] > 0)
					{ $sx .= '<TD width="'.$size.'%" align="center"  class="table_resume_td_sel"><B>'.msg('pesq_relate'); }
					
				if ($perfil->valid("#SCR#COO#ADM"))
					{ $sx .= '<TH width="'.$size.'%" align="center">'.msg('pesq_revisao'); }
				$sx .= '<TH width="'.$size.'%" align="center">'.msg('pesq_assignada');
				$sx .= '<TH width="'.$size.'%" align="center">'.msg('pesq_reunion');
				$sx .= '<TH width="'.$size.'%" align="center">'.msg('pesq_filed');
				if (($tp[7] > 0) and ($perfil->valid("#SCR#COO#ADM")))
					{ $sx .= '<TD width="'.$size.'%" align="center"><B>'.msg('research_ongoing'); }
				
				if ($tp[0] > 0) { $link[0] = '<A HREF="protocols.php?dd1=@" class="table_resume_td">'; }
				if ($tp[1] > 0) { $link[1] = '<A HREF="protocols.php?dd1=A" class="table_resume_td">'; }
				if ($tp[2] > 0) { $link[2] = '<A HREF="protocols.php?dd1=B" class="table_resume_td">'; }
				if ($tp[3] > 0) { $link[3] = '<A HREF="protocols.php?dd1=C" class="table_resume_td">'; }
				if ($tp[4] > 0) { $link[4] = '<A HREF="protocols.php?dd1=D" class="table_resume_td">'; }
				if ($tp[5] > 0) { $link[5] = '<A HREF="protocols.php?dd1=H" class="table_resume_td">'; }
				if ($tp[6] > 0) { $link[6] = '<A HREF="protocols.php?dd1=E" class="table_resume_td">'; }
				if ($tp[7] > 0) { $link[7] = '<A HREF="protocols.php?dd1=P" class="table_resume_td">'; }
				if ($tp[9] > 0) { $link[9] = '<A HREF="protocols.php?dd1=Z" class="table_resume_td">'; }
				
				$sx .= '<TR  class="table_resume_td">';
				if ($perfil->valid("#SCR#COO#ADM"))
					{ $sx .= '<TD align="center">'.$link[1].round($tp[1]).'</A>'; }
				if ($tp[5] > 0)
					{ $sx .= '<TD  align="center">'.$link[5].round($tp[5]).'</A>'; }
				if (($tp[6] > 0) and ($perfil->valid("#SCR#COO#ADM")))
					{ $sx .= '<TD  align="center">'.$link[6].round($tp[6]).'</A>'; }
				if ($tp[9] > 0)
					{ $sx .= '<TD  align="center">'.$link[9].round($tp[9]).'</A>'; }
				if ($perfil->valid("#SCR#COO#ADM"))
					{ $sx .= '<TD align="center">'.$link[2].round($tp[2]).'</A>'; }
					
				$sx .= '<TD align="center">'.$link[3].round($tp[3]).'</A>';
				$sx .= '<TD align="center">'.$link[4].round($tp[4]).'</A>';
				$sx .= '<TD align="center">'.$link[5].round($tp[5]).'</A>';
				/* Finalizados */
				if (($tp[7] > 0) and ($perfil->valid("#SCR#COO#ADM")))
					{ $sx .= '<TD  align="center">'.$link[7].round($tp[7]).'</A>'; }

				$sx .= '</table>';
				 
				
				//$sx .= '</fieldset>';
				//$sx .= '</table>';				

				return($sx);
			}

		function resume_adhoc()
			{
			global $tab_max,$message,$ss,$perfil;
			$tp = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			$us = strzero(round($ss->user_id),7);				
									
			$sql = "select count(*) as total from cep_dictamen 
					inner join cep_protocolos on pp_protocolo = cep_protocol
					where 
					 (cep_status = '@' or cep_status = 'A' or cep_status = 'B' or cep_status = 'C' or cep_status = 'D')
					 and pp_avaliador = '$us' 
					 and (pp_status <> 'B' and pp_status <> 'X') 
					";
			$rlt = db_query($sql);
			while ($line = db_read($rlt))
				{
					$tp[9] = $line['total'];
				}
				
				$sx .= '<font class="lt4">'.msg('resume_adhoc').'</font>';
				$sx .=  '<Table width="100%" class="table_resume" align="center" >';
				$sx .=  '<TR><TD>';
				$sx .=  '<fieldset><legend>'.msg('research').'</legend>';
				$sx .=  '<Table width="120" class="table_resume" border=1 >';
				/* Protocolo em Submissao */
				
				$size = 15;
				$sx .= '<TR  class="table_resume_th" align="center"> ';
				if ($tp[9] > 0)
					{ $sx .= '<TD width="'.$size.'%" align="center"  class="table_resume_td_sel"><B>'.msg('pesq_relate'); }
				
				if ($tp[9] > 0) { $link[9] = '<A HREF="protocols.php?dd1=Z" class="table_resume_td">'; }
				
				$sx .= '<TR  class="table_resume_td">';
				if ($perfil->valid("#ADC"))
					{ $sx .= '<TD align="center">'.$link[9].round($tp[9]).'</A>'; }
					
				$sx .= '</table>';
				
				$sx .= '</fieldset>';
				$sx .= '</table>';				
				
				if ($tp[9] == 0) { $sx = ''; }
				return($sx);
			}

	}
	
?>