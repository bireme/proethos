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
     * BreadCrumbs
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package class
	 * @subpackage reports
    */
class cep_reports
	{
		
		function report_004($perf='#MEM')
			{

				$sql = "
					SELECT * FROM usuario_perfis_ativo 
						left join usuario on up_usuario = us_codigo
						WHERE up_perfil = '$perf' and up_ativo = 1				
				";
				$sx = '<table width="100%" class="tabela00">';
				$sx .= '<TR><TH>'.msg('name');
				$sx .= '<TH>'.msg('institution');
				$sx .= '<TH>'.msg('email');
				
				$rlt = db_query($sql);
				while ($line = db_read($rlt))
				{
						$st = '<h2>'.trim($line['usp_descricao']).'</h2>';
						$sx .= '<TR valign="top">';
						$sx .= '<TD>'.$line['us_nome'];
						$sx .= '<TD>'.$line['us_instituition'];
						$sx .= '<TD class="lt0">'.$line['us_email'];
						if (strlen(trim($line['us_email_alt'])) > 0)
							{
								$sx .= '<TD class="lt0">'.$line['us_email_alt'];
							}
				}
				$sx .= '</table>';	
				return($sx);				
			}		
		function report_003()
			{
				$sql = "select * from usuario
						order by us_nome
				";
				$sx = '<table width="100%" class="table_proj">';
				$sx .= '<TR><TH>'.msg('name');
				$sx .= '<TH>'.msg('institution');
				$sx .= '<TH>'.msg('email');
				
				$rlt = db_query($sql);
				while ($line = db_read($rlt))
				{
						$sx .= '<TR valign="top">';
						$sx .= '<TD>'.$line['us_nome'];
						$sx .= '<TD>'.$line['us_instituition'];
						$sx .= '<TD>'.$line['us_email'];
						if (strlen(trim($line['us_email_alt'])) > 0)
							{
								$sx .= '<BR>'.$line['us_email_alt'];
							}
				}
				$sx .= '</table>';	
				return($sx);				
			}		
		function report_002()
			{
				global $cep;
				$sql = "select * from cep_protocolos 
						where cep_tipo = 'PRO'
						and cep_status = 'P'
						
						order by cep_monitoring				
				";
				$rlt = db_query($sql);

				$id = 0;
				$sx = '<table width="100%" class="table_proj">';
				$sx .= '<TR><TH>'.msg('caae');
				$sx .= '<TH>'.msg('protocol_title');
				$sx .= '<TH><nobr>'.msg('monitoring');
				$sx .= '<TH>'.msg('status');
				
				while ($line = db_read($rlt))
					{
						$bgcor = '';
						if ($line['cep_monitoring'] < date("Ymd"))
							{ $bgcor = 'style="background-color:#FF8080; " ';}
						$id++;
						$link = '<A HREF="protocolo_detalhe_investigator.php?dd0='.$line['id_cep'].'&dd90='.checkpost($line['id_cep']).'">';
						$sx .= chr(13);
						$sx .= '<TR valign="top">';
						$sx .= '<TD>'.$link;
						$sx .= $line['cep_caae'];
						$sx 	.= '<TD>'.$link;	
						$sx .= $line['cep_titulo'];
						$sx .= '<TD '.$bgcor.'>'.$link;	
						$sx .= stodbr($line['cep_monitoring']);
						$sx .= '<TD>'.$link;	
						$sx .= $cep->mostra_status($line['cep_status']);
					}
				$sx .= '</table>';	
			return($sx);
			}
		function report_001a($ano='')
			{
				if (strlen($ano)==0) { $ano = date("Y"); }	
				
				$sql = "select cep_data, count(*) as total  from (
						select round(cep_data/100) as cep_data
						from cep_protocolos 
						where cep_status <> '@'
						and cep_tipo = 'PRO'
						and round(cep_data/10000) = $ano
						) as tabela
						group by cep_data
						order by cep_data
				";
				$rlt = db_query($sql);
				$max = 10;
				/* Calcula o maximo */
				while ($line = db_read($rlt))
					{ if (($line['total']) > $max) { $max = $line['total']; } }
				
				$rlt = db_query($sql);
				$sx = '<table width="100%" class="table_proj">';
				$sx .= '<TR><TH width="8%">'.msg('year');
				for ($r=1;$r <= 12;$r++)
					{
						$sx .= '<TH width="8%">';
						$sx .= msg('month_'.strzero($r,2));
					}
				
				$xano = -1;
				$xmes = 0;
				$sa = ''; $sb = '';
				while ($line = db_read($rlt))
					{
						$ano = round($line['cep_data']/100);
						$mes = round(substr($line['cep_data'],4,2));
						if ($ano != $xano)
							{
								$sx .= $sb;
								$sx .= $sa;
								$sa = ''; $sb = '';
								$sa = '<TR><TD align="center">'.$ano; $xano = $ano; $xmes = 1;
								$sb = '<TR><TD>&nbsp;'; 
							}
						
						for ($r=$xmes;$r < $mes;$r++)
							{ $sa .= '<TD align="center">-'; $sb .= '<TD align="center">-'; }	
						$xmes = ($mes+1);
						$sa .= '<TD align="center">';
						$sb .= '<TD align="center" valign="bottom" height="80">';
						
						$sa .= $line['total'];
						$hg = round( (30 * ($line['total']) / $max));
						$sb .= '<img src="img/gr_point_blue.png" width="30" height="'.$hg.'">';
						
					}
				$sx .= $sb.$sa;
				$sx .= '</table>';
				echo $sx;
				
			}

		function report_001b($ano='')
			{
				if (strlen($ano)==0) { $ano = date("Y"); }	
				
				$sql = "select cep_data, count(*) as total  from (
						select round(cep_dt_liberacao/100) as cep_data
						from cep_protocolos 
						where cep_status <> '@'
						and cep_tipo = 'PRO'
						and cep_dt_liberacao > 20000101
						and round(cep_dt_liberacao/10000) = $ano
						) as tabela
						group by cep_data
						order by cep_data
				";
				$rlt = db_query($sql);
				$max = 10;
				/* Calcula o maximo */
				while ($line = db_read($rlt))
					{ if (($line['total']) > $max) { $max = $line['total']; } }
				
				$rlt = db_query($sql);
				$sx = '<table width="100%" class="table_proj">';
				$sx .= '<TR><TH width="8%">'.msg('year');
				for ($r=1;$r <= 12;$r++)
					{
						$sx .= '<TH width="8%">';
						$sx .= msg('month_'.strzero($r,2));
					}
				
				$xano = -1;
				$xmes = 0;
				$sa = ''; $sb = '';
				while ($line = db_read($rlt))
					{
						$ano = round($line['cep_data']/100);
						$mes = round(substr($line['cep_data'],4,2));
						if ($ano != $xano)
							{
								$sx .= $sb;
								$sx .= $sa;
								$sa = ''; $sb = '';
								$sa = '<TR><TD align="center">'.$ano; $xano = $ano; $xmes = 1;
								$sb = '<TR><TD>&nbsp;'; 
							}
						
						for ($r=$xmes;$r < $mes;$r++)
							{ $sa .= '<TD align="center">-'; $sb .= '<TD align="center">-'; }	
						$xmes = ($mes+1);
						$sa .= '<TD align="center">';
						$sb .= '<TD align="center" valign="bottom" height="80">';
						
						$sa .= $line['total'];
						$hg = round( (30 * ($line['total']) / $max));
						$sb .= '<img src="img/gr_point_blue.png" width="30" height="'.$hg.'">';
						
					}
				$sx .= $sb.$sa;
				$sx .= '</table>';
				echo $sx;
				
			}
		function report_001c($ano='')
			{
				if (strlen($ano)==0) { $ano = date("Y"); }	
				
				$sql = "select cep_data, count(*) as total  from (
						select round(pr_data/100) as cep_data
						from cep_parecer 
						where pr_status = 'F'
						and pr_data > 20000101
						and round(pr_data/10000) = $ano
						) as tabela
						group by cep_data
						order by cep_data
				";
				$rlt = db_query($sql);
				$max = 10;
				/* Calcula o maximo */
				while ($line = db_read($rlt))
					{ if (($line['total']) > $max) { $max = $line['total']; } }
				
				$rlt = db_query($sql);
				$sx = '<table width="100%" class="table_proj">';
				$sx .= '<TR><TH width="8%">'.msg('year');
				for ($r=1;$r <= 12;$r++)
					{
						$sx .= '<TH width="8%">';
						$sx .= msg('month_'.strzero($r,2));
					}
				
				$xano = -1;
				$xmes = 0;
				$sa = ''; $sb = '';
				while ($line = db_read($rlt))
					{
						$ano = round($line['cep_data']/100);
						$mes = round(substr($line['cep_data'],4,2));
						if ($ano != $xano)
							{
								$sx .= $sb;
								$sx .= $sa;
								$sa = ''; $sb = '';
								$sa = '<TR><TD align="center">'.$ano; $xano = $ano; $xmes = 1;
								$sb = '<TR><TD>&nbsp;'; 
							}
						
						for ($r=$xmes;$r < $mes;$r++)
							{ $sa .= '<TD align="center">-'; $sb .= '<TD align="center">-'; }	
						$xmes = ($mes+1);
						$sa .= '<TD align="center">';
						$sb .= '<TD align="center" valign="bottom" height="80">';
						
						$sa .= $line['total'];
						$hg = round( (30 * ($line['total']) / $max));
						$sb .= '<img src="img/gr_point_blue.png" width="30" height="'.$hg.'">';
						
					}
				$sx .= $sb.$sa;
				$sx .= '</table>';
				echo $sx;
				
			}
	}
?>