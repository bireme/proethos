<?php
    /**
     * Budget
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage budget
    */
class budget
	{
	var $protocolo;
	var $tabela = 'cep_submit_orca';
	var $tabela_crono = 'cep_submit_crono';	
	function budget_list($protocol)
		{
			global $tab_max;
			$sql = "select * from ".$this->tabela."
				where sorca_protocol = '".$protocol."' and sorca_ativo = 1
				order by sorca_valor desc";
			$rlt = db_query($sql);
			$it = 0;
			$tot = 0;
			$toti = 0;
			$sx .= '<table width="100%" class="tabela01 lt1" cellpadding=5> ';
			$sx .= '<TR class="lt0">';
			$sx .= '<TH width="5%">'.msg('budget_item');
			$sx .= '<TH>'.msg('budget_desc');
			$sx .= '<TH width="8%">'.msg('budget_vlr');
			$sx .= '<TH width="5%">'.msg('budget_qt');
			$sx .= '<TH width="10%">'.msg('budget_vlrt');
			while ($line = db_read($rlt))
				{
					$link = "<A HREF=\"javascript:newxy2('submit_ajax.php?dd10=budget&dd0=".$line['id_sorca'];
					$link .= '&dd11='.checkpost($line['id_sorca'])."&dd12=DEL',200,100);\">";
					$it++;
					$toti = $toti + $line['sorca_unid'];
					$tot = $tot + $line['sorca_unid']*$line['sorca_valor'];
					$sx .= '<TR>';
					$sx .= '<TD align="center">'.$it;
					$sx .= '<TD align="left">'.trim($line['sorca_descricao']);
					$sx .= '<TD align="right">'.number_format($line['sorca_valor'],2,',','.');
					$sx .= '<TD align="right">'.number_format($line['sorca_unid'],0,',','.');
					$sx .= '<TD align="right">'.number_format($line['sorca_valor'] * $line['sorca_unid'],2,',','.');
					$sx .= '<TD align="right" width="10">';
					$sx .= $link;
					$sx .= '<img src="img/icone_remove.png" border=0>';
					$sx .= '</A>';
				}
			$sx .= '<TR><TD>';
			$sx .= '<TD align="right" colspan=2><B><I>'.number_format($it,0).' '.msg('budget_item');
			$sx .= '<TD align="right"><B><I>'.number_format($toti,0,',','.');
			$sx .= '<TD align="right"><B><I>'.number_format($tot,2,',','.');
			$sx .= '</table>';
			return($sx);
		}

	function budget_iten_del($id)
		{
			$sql = "update ".$this->tabela." set sorca_ativo = 0 where id_sorca = ".round($id);
			$rlt = db_query($sql);
			return(1);
		}
	function budget_iten_insert($protocol,$desc,$quan,$value,$finan)
		{
			$sql = "select * from ".$this->tabela."
				where sorca_descricao = '".$desc."'
				and sorca_unid = ".$quan."
				and sorca_valor = ".$value."
				and sorca_protocol = '".$protocol."'
				and sorca_finan = '".$finan."' 
				and sorca_ativo = 1 ";
				
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					return(0);
				} else {
					$sql = "insert into ".$this->tabela."
						(sorca_descricao, sorca_unid, sorca_valor,
						sorca_protocol, sorca_ativo, sorca_finan )
						values
						('$desc','$quan','$value',
						'$protocol',1,'$finan');
					";
					$rlt = db_query($sql);
					return(1);
				}
		}
	function form_budget()
		{
			$sx .= '<table width="50%" class="tabela01" border=0 align="right">';

			
			/* Form */
			$sx .= '
			<style>
				#dd3 { width: 300px; }
				#dd4 { width: 70px; }
				#dd5 { width: 70px; }
			</style>';
			$sx .= '<TR>';
			$sx .= '<TD>';
			$sx .= gets('dd3a',$dd[3],'$S80',msg('budget_desc'),0,1,'','','');
			$sx .= gets('dd5a',$dd[5],'$I8'.$op,msg('budget_vlr'),'','');
			$sx .= gets('dd4a',$dd[4],'$I8'.$op,msg('budget_qt'),'','');
			$sx .= '<TR><TD colspan=2><input type="button" id="budget_post" value="'.msg('budget_post').'">';
			$sx .= '</table>';
			$sx .= '</div>';
			
			$cr = chr(13).chr(10);
			$sx .= '<script>'.$cr;
			$sx .= '$("#budget_post").click(function() 
				{
					var v1 = $(\'#dd3a\').val();
					var v2 = $(\'#dd4a\').val();
					var v3 = $(\'#dd5a\').val();  
					var site = \'submit_ajax_php\';
					var site = site + \'?dd1=\'+v1;
					var site = site + \'&dd2=\'+v2;
					var site = site + \'&dd3=\'+v3;
					var ok = 1;
					if (v1.length == 0) { ok = 0; alert(\'Descriction is necessary\'); }
					if (v2.length == 0) { ok = 0; alert(\'Quant. is necessary\'); }
					if (v3.length == 0) { ok = 0; alert(\'Unit value is necessary\'); }
					
					if (ok == 1)
					{ 
			 		$.ajax({
			 				url: "submit_ajax.php",
			 				type: "POST",
			 				data: { dd1: v1, dd2: v2, dd3: v3 , dd10: "budget" ,dd11: "'.$this->protocol.'" }
			 		 }) 
					.fail(function() { alert("error #03"); })
			 		.success(function(data) { $("#budget").html(data); });
					} 
				});
				
			'.$cr;
			$sx .= '</script>'.$cr;
			return($sx);
		}	

	function crono_list($protocol)
		{
			global $tab_max;
			$sql = "select * from ".$this->tabela_crono."
				where scrono_protocol = '".$protocol."' and scrono_ativo = 1
				order by scrono_date_start ";
			$rlt = db_query($sql);
			$it = 0;
			$tot = 0;
			$toti = 0;
			$sx .= '<table width="'.$tab_max.'" class="lt1">';
			$sx .= '<TR>';
			$sx .= '<TH width="5%">'.msg('crono_item');
			$sx .= '<TH>'.msg('crono_desc');
			$sx .= '<TH width="5%">'.msg('crono_dtini');
			$sx .= '<TH width="8%">'.msg('crono_dtfim');
			while ($line = db_read($rlt))
				{
					$link = "<A HREF=\"javascript:newxy2('submit_ajax.php?dd10=crono&dd0=".$line['id_scrono'];
					$link .= '&dd11='.checkpost($line['id_scrono'])."&dd12=DEL',200,100);\">";
					$it++;		
					$di = $line['scrono_date_start'];
					$df = $line['scrono_date_end'];
					$di = substr($di,4,2).'/'.substr($di,0,4);
					$df = substr($df,4,2).'/'.substr($df,0,4); 			
					$sx .= '<TR>';
					$sx .= '<TD align="center">'.$it;
					$sx .= '<TD align="left">'.trim($line['scrono_descricao']);
					$sx .= '<TD align="right">'.$di;
					$sx .= '<TD align="right">'.$df;
					$sx .= '<TD align="right" width="10">';
					$sx .= $link;
					$sx .= '<img src="img/icone_remove.png" border=0>';
					$sx .= '</A>';
				}
			$sx .= '<TR>';
			$sx .= '<TD align="left" colspan=5><B><I>'.number_format($it,0).' '.msg('budget_item');
			$sx .= '</table>';
			return($sx);
		}
	function crono_iten_del($id)
		{
			$sql = "update ".$this->tabela_crono." set scrono_ativo = 0 where id_scrono = ".round($id);
			$rlt = db_query($sql);
			return(1);
		}
	function crono_iten_insert($protocol,$desc,$dti,$dtf,$finan)
		{
			$sql = "select * from ".$this->tabela_crono."
				where scrono_descricao = '".$desc."'
				and scrono_date_start = ".$dti."
				and scrono_date_end = ".$dtf."
				and scrono_protocol = '".$protocol."'
				and scrono_ativo = 1 ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					return(0);
				} else {
					$sql = "insert into ".$this->tabela_crono."
						(scrono_descricao, scrono_date_start, scrono_date_end,
						scrono_protocol, scrono_ativo )
						values
						('$desc','$dti','$dtf',
						'$protocol',1);
					";
					$rlt = db_query($sql);
					return(1);
				}
		}
	function form_crono()
		{
			$sx .= '<table width="100%" class="lt0">';
			$sx .= '<TR>';
			$sx .= '<TD>'; 
			$sx .= '</table>';

			$sx .= '<table width="100%"  class="lt0" border=0 >';
			$sx .= '<TR bgcolor="#C0C0C0"><TH width=5%>'.msg('crono_item');
			$sx .= '<TH width=60%>'.msg('crono_desc');
			$sx .= '<TH>'.msg('crono_qt');
			$sx .= '<TH>'.msg('crono_vlr');
			$sx .= '<TH>&nbsp;';
						
			/* Form */
			$sx .= '
			<style>
				#dd3 { width: 300px; }
				#dd4 { width: 70px; }
				#dd5 { width: 70px; }
			</style>';
			$op = ' ';
			for ($r1=date("Y");$r1 <= (date("Y")+20); $r1++)
				{
					for ($r2=1;$r2 <= 12;$r2++)
						{ $op .= '&'.strzero($r2,2).$r1.':'.strzero($r2,2).'/'.$r1; }
				}
			$sx .= '<TR>';
			$sx .= '<TD>';
			$sx .= gets('dd6a',$dd[6],'$S80',$dd[6],0,1,'','form_textarea_full','');
			$sx .= gets('dd7a',$dd[7],'$O '.$op,$dd[7],'','');
			$sx .= gets('dd8a',$dd[8],'$O '.$op,$dd[8],'','');
			$sx .= '<TD><input type="button" id="crono_post" value="'.msg('crono_post').'">';
			$sx .= '</table>';
			$sx .= '</div>';
			
			$cr = chr(13).chr(10);
			$sx .= '<script>'.$cr;
			$sx .= '$("#crono_post").click(function() 
				{
					
					var v1 = $(\'#dd6a\').val();
					var v2 = $(\'#dd7a\').val();
					var v3 = $(\'#dd8a\').val();  
					
					var site = \'submit_ajax_php\';
					var site = site + \'?dd1=\'+v1;
					var site = site + \'&dd2=\'+v2;
					var site = site + \'&dd3=\'+v3;
					var ok = 1;
					if (v1.length == 0) { ok = 0; alert(\'Descriction is necessary\'); }
					if (v2.length == 0) { ok = 0; alert(\'Inicial date is necessary\'); }
					if (v3.length == 0) { ok = 0; alert(\'Final date is necessary\'); }
					
					if (ok == 1)
					{ 
			 		$.ajax({
			 				url: "submit_ajax.php",
			 				type: "POST",
			 				data: { dd1: v1, dd2: v2, dd3: v3 , dd10: "crono" ,dd11: "'.$this->protocol.'" }
			 		 }) 
					.fail(function() { alert("error #04"); })
			 		.success(function(data) { $("#crono").html(data); });
					} 
				});
				
			'.$cr;
			$sx .= '</script>'.$cr;
			return($sx);
		}	


	}
?>