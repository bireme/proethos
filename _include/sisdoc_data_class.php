<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @copyright � Pan American Health Organization, 2013. All rights reserved.
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage Date
*/

class date
	{
		var $date;
		var $format='DD/MM/YYYY';
		var $day;
		var $month;
		var $year;
		
		/* Converte Data para String */
		function dtos($dt,$LANG='')
			{
				global $i_date_format;
				$fmt = $i_date_format;
				$dr = '';
				
				$dr = $this->brtos($dt);
				if (strlen($fmt) == 0) { $fmt = 'DD/MM/YYYY'; }
				switch ($fmt)
					{
					case "MM/DD/YYYY": 
							$dr = $this->ustos($dt); break;
					default:  break;
					}
				/* Ingles */
				if ($LANG == 'en_US')
					{
						$dr = $this->ustos($dt); 
					}
				return($dr);		
			}
			
		/* Converte String para Data */
		function stod($dt)
			{
				global $i_date_format;
				$fmt = $i_date_format;
				$dr = $this->stodbr($dt);
	
				if (strlen($fmt) == 0) { $fmt = 'DD/MM/YYYY'; }
				switch ($fmt)
					{
					case "MM/DD/YYYY": $dr = $this->stous($dt); break;
					}
				return($dr);
			}
		
		/* Bisexto ano */
		function ano_bisexto($ddb)	
		{
			if (intval($ddb/4) == ($ddb/4))
				{ return(True); } else
				{ return(False); }
		}
		
		/* Convert String no format DD/MM/YYYY */
		function stodbr($dt)
			{
				if (($dt == '19000101') or ($dt == '0') or ($dt == ''))
				{
					$ds = ''; 
				} else {
					$ds = substr($dt,6,2).'/'.substr($dt,4,2).'/'.substr($dt,0,4);	
				}
				return($ds);
			}
		/* Convert String no format MM/DD/YYYY */
		function stodus($dt)
			{
				if (($dt = '19000101') or ($dt == '0') or ($dt == ''))
				{
					$ds = ''; 
				} else {
					$ds = substr($dt,4,2).'/'.substr($dt,6,2).'/'.substr($dt,0,4);	
				}
				return($ds);
			}		
			
		/* Convert DD/MM/YYYY em String */
		function brtos($dt)
			{
				$ds = round(substr($dt,6,4).substr($dt,3,2).substr($dt,0,2));
				if ($ds <= 19000101) { $ds = '19000101'; }
				return($ds);
			}
				
		/* Convert MM/DD/YYYY em String */
		function ustos($dt)
			{
				$ds = round(substr($dt,6,4).substr($dt,0,2).substr($dt,3,2));
				if ($ds <= 19000101) { $ds = '19000101'; }
				return($ds);
			}
		/* Converte String para DateTime */
		function stodatetime($dds)
			{
			$ddt = mktime(0, 0, 0, substr($dds,4,2),substr($dds,6,2) , substr($dds,0,4));
			return($ddt);	
			}
			
		/* Function MakeData */
		function maketime($dds)
			{
			$ddt = mktime(0, 0, 0, substr($dds,4,2),substr($dds,6,2) , substr($dds,0,4));
			return($ddt);
			}
		
		/* Calcula o dia da semana */
		function weekday($ddt)
			{
			global $date;
			if (strpos($ddt,'/') > 0) { $ddt = $this->dtos($ddt); }
			$ddt = $this->maketime($ddt);
			$nd = date('w',$ddt);
			return($nd);		
			}
			
		/* Dia da Semana */
		function weekday_name($ddt,$tp='1')
		{
			global $LANG;			
			$cp_pt_BR = array('Domingo'=>1,'Segunda'=>2,'Ter�a'=>3,'Quarta'=>4,'Quinta'=>5,'Sexta'=>6,'S�bado'=>7);
			$cp_en_US = array('Sunday'=>1,'Monday'=>2,'Tuesday'=>3,'Wednesday'=>4,'Thursday'=>5,'Friday'=>6,'Saturday'=>7);
			$cp_es = array('Domingo' => 1, 'Lunes' => 2, 'Martes' => 3, 'Mi�rcoles' => 4, 'Jueves' => 5, 'Viernes' => 6, 'S�bado' => 7);

			/* Tipo Completo */
			$cp = $cp_pt_BR;
			switch ($LANG)
				{
				case ('en_US'): $cp = $cp_en_US; break;
				case ('es'): $cp = $cp_es; break;
				}
			$rsp = $cp[$ddt];
			/* Tipo Abreviado */
			if ($tp == '2')
				{ $rsp = substr($rsp,0,3).'.'; }
			return($rsp);
		}
		
		/* Nome do mes */
		function month_name($dx,$tp='1')
		{
			global $LANG;
			$cp_pt_BR = array("","Janeiro","Fevereiro","Mar�o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
			$cp_en_US = array("","January","February","March","April","May","June","July","August","Septeber","October","November","Dezember");
			$cp_es     = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre", "Octubre", "Noviembre","Diciembre");
			
			$cp_abre_pt_BR = array("","Jan.","Fev.","Mar.","Abr.","Maio","Jun.","Jul.","Ago.","Set.","Out.","Nov.","Dez.");
			$cp_abre_en_US = array("","Jan.","Feb.","Mar.","Apr.","May","June","July","Aug.","Sept.","Oct.","Nov.","Dez.");
			$cp_abre_es     = array("","Ene.","Feb.","Mar.","Abr.","Mayo","Jun.","Jul.","Ago.","Sep.", "Oct.", "Nov.","Dic.");

			/* Tipo Completo */
			if ($tp == '1')
				{
					$cp = $cp_pt_BR;
					//echo 'oi==>'.count($cp);
					switch ($LANG)
						{
						case ('en_US'): $cp = $cp_en_US; break;
						case ('es'): $cp = $cp_es; break;
						}
				} 
			/* Tipo Abreviado */
			if ($tp == '2')
				{
					$cp = $cp_abre_pt_BR;
					switch ($LANG)
						{
						case ('en_US'): $cp = $cp_abre_en_US; break;
						case ('es'): $cp = $cp_abre_es; break;
						}
				} 
			$rt = $cp[$dx];
			return($cp[$dx]);
		}
	}
