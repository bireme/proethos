<?php
    /**
     * Calender
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage calender
    */
class calendar
	{
		var $tabela = 'calender';
		var $tabela_type = 'calender_type';
		
		function actions_list($act)
			{
				$sx = '';
				if (count($act) > 0)
				{
				$sx = '<table width="100%" class="lt1">';
				$sx .= '<TR><TH width="6%" align="center">'.msg('day');
				$sx .= '<TH width="10%" align="center">'.msg('hour');
				$sx .= '<TH width="84%">'.msg('description');
				for ($r=0;$r < count($act);$r++)
					{
						$bgcolor = trim($act[$r][4]);
						if (strlen($bgcolor) > 0)
							{
								$bgcolor = 'style="background-color: '.$bgcolor.'; " ';
							}
						$sx .= '<TR>';
						$sx .= '<TD '.$bgcolor.' align="center">'.substr($act[$r][0],6,2);
						$sx .= '<TD align="center">'.substr($act[$r][1],0,5);
						//$sx .= '<TD align="center">'.$act[$r][2];
						$sx .= '<TD align="left">'.$act[$r][3];
					}
				$sx .= '</table>';
				}
				return($sx);
			}
		
		function actions($mes='')
			{
				if (strlen($mes)==0) { $mes = date("Ym"); }
				$mes = substr($mes,0,6);
				$mes1 = $mes.'00';
				$mes2 = $mes.'99';
				$sql = "select * from ".$this->tabela."
					inner join ".$this->tabela_type." on cal_cod = calt_codigo  
					where 
					cal_date >= '$mes1' and cal_date <= '$mes2'
					order by cal_date, cal_time
				";
				$rlt = db_query($sql);
				$act = array();
				while ($line = db_read($rlt))
					{
						array_push($act,array($line['cal_date'],$line['cal_time'],$line['cal_cal_description'],$line['calt_descricao'],$line['calt_color']));
					}
				return($act);			
			}
		
		function row()
		{
			global $tabela,$http_edit,$http_edit_para,$cdf,$cdm,$masc,$offset,$order;
			$cdf = array('id_cal','cal_date','cal_time','cal_description','cal_ativo');
			$cdm = array('ID',msg('date'),msg("time"),msg('description'),msg('ativo'));
			$masc = array('','D','','','SN','','','','');
			return(True);
		}
		function row_type()
		{
			global $tabela,$http_edit,$http_edit_para,$cdf,$cdm,$masc,$offset,$order;
			$cdf = array('id_calt','calt_descricao','calt_codigo','calt_color','calt_ativo');
			$cdm = array('ID',msg('calender_type'),msg("cod"),msg('color'),msg('ativo'));
			$masc = array('','','','','','','','','');
			return(True);
		}
				
		function calendar($mes='',$events=array(),$topcolo='#000000')
			{
			global $date;
			$sx = '
				<TABLE width="200" cellpadding="3" cellspacing="0" class="lt1" border=0>
				<TR align="center" bgcolor="'.$topcolo.'" align="center" class="lt0">
				<TD width="14%"><center><font color="#ffffff">D</TD>
				<TD width="14%"><center><font color="#ffffff">S</TD>
				<TD width="14%"><center><font color="#ffffff">T</TD>
				<TD width="14%"><center><font color="#ffffff">Q</TD>
				<TD width="14%"><center><font color="#ffffff">Q</TD>
				<TD width="14%"><center><font color="#ffffff">S</TD>
				<TD width="14%"><center><font color="#ffffff">S</TD>
				</TR>
				<TR>
			';
			if (strlen($mes)==0)
				{
					$dd1 = date("Ym").'01';
					$dd2 = date("Ym").'01';
				} else {
					$dd1 = substr($mes,0,6).'01';
					$dd2 = substr($mes,0,6).'01';					
				}
			$dd3=$date->weekday($dd1)+1;
		

			for ($k = 1; $k < $dd3; $k++) { $sx .= '<TD>&nbsp;</TD>'; }
			while (substr($dd1,0,6) == substr($dd2,0,6))
				{
				$ndia = round(substr($dd2,6,2));
				/* Events */
				$bgcolor = '';
				for ($r=0;$r < count($events);$r++)
					{
						if ($dd2 == $events[$r][0]) 
						{ $bgcolor = 'style="background-color: '.$events[$r][4].'; " ';; }
					}
				/* Monta calendario */
				$mst_vlr = '';
				if ($vlr[$ndia] > 0) { $mst_vlr = Number_format($vlr[$ndia],2); }
				$link = '<A HREF="'.$pg.'?dd0='.$dd2.'" title="'.$mst_vlr.'" class="lt1">';
				$wd = $date->weekday($dd2)+1;
				if (($wd == 1) and ($ndia > 1)) { $sx .= '<TR align="center">'; }
				$sx .= '<TD align="center" '.$bgcolor.' class="table_calender">';
				//$sx .= $link;
				$sx .= $ndia;
				$dd2 = DateAdd('d',1,$dd2);
				}
			$sx .= '</TABLE>';
			return($sx);				
			}

		function strucuture()
			{
				$sql = "
					CREATE TABLE calender
						(
							id_cal serial NOT NULL,
							cal_date integer,
							cal_time char(5),
							cal_cod char(3),
							cal_description char(80),
							cal_public char(1),
							cal_ativo integer
						)";
				$rlt = db_query($sql);
				$sql = "
					CREATE TABLE calender_type
						(
							id_calt serial NOT NULL,
							calt_codigo char(3),
							calt_descricao char(80),
							calt_color char(7),
							calt_ativo integer							
						)
				";
				$rlt = db_query($sql);
			}
			
		function cp_type()
			{
				global $messa,$dd;
				$cp = array();
				array_push($cp,array('$H8','id_calt','',False,True));
				array_push($cp,array('$S80','calt_descricao',msg('description'),True,True));
				array_push($cp,array('$H8','calt_codigo','',False,True));
				array_push($cp,array('$S7','calt_color',msg('color'),False,True));
				array_push($cp,array('$O 1:YES&0:NO','calt_ativo',msg('ativo'),False,True));
				return($cp);
			}	
			
		function cp()
			{
				global $messa,$dd;
				$cp = array();
				array_push($cp,array('$H8','id_cal','',False,True));
				array_push($cp,array('$D8','cal_date',msg('date'),True,True));
				array_push($cp,array('$S5','cal_time',msg('time'),False,True));
				array_push($cp,array('$S80','cal_description',msg('description'),True,True));
				array_push($cp,array('$Q calt_descricao:calt_codigo:select * from '.$this->tabela_type.' where calt_ativo = 1','cal_cod',msg('type'),False,True));
				array_push($cp,array('$O 1:YES&0:NO','cal_ativo',msg('ativo'),False,True));
				array_push($cp,array('$O 1:YES&0:NO','cal_public',msg('public'),False,True));
				
				return($cp);
			}		
		function updatex()
			{
				global $base;
				$c = 'cal';
				$c1 = 'id_'.$c;
				$c2 = $c.'_cod';
				$c3 = 3;
				$sql = "update ".$this->tabela_type." set $c2 = lpad($c1,$c3,0) 
						where $c2='' or 1=1";
				if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')) where $c2='' "; }
				$rlt = db_query($sql);				
			}			
	}
