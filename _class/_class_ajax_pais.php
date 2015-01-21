<?php
    /**
     * BreadCrumbs
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage country
    */
class country
	{
		var $tabela = 'ajax_pais';
		var $protocol;
	
	function country_iten_del($id,$proto)
		{
			$sql = "update cep_submit_country set ctr_ativo = 0 
				where id_ctr = ".round($id)." and ctr_protocol = '$proto'";
				
			$rlt = db_query($sql);
			return(1);
		}
	function country_iten_insert($protocol,$desc,$target)
		{
			$sql = "select * from cep_submit_country
				where 
				ctr_country = ".$desc."
				and ctr_protocol = '".$protocol."'
				and ctr_ativo = 1 ";
				
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					return(0);
				} else {
					$sql = "insert into cep_submit_country
						(ctr_country, ctr_protocol, ctr_target, ctr_ativo)
						values
						('$desc','$protocol','$target',1);
					";
					$rlt = db_query($sql);
					return(1);
				}
		}		
	function form_country()
			{
			$sx .= '<table width="100%"  class="lt0" border=0>';
			$sx .= '<TR bgcolor="#C0C0C0"><TH width=5%>'.msg('country_item');
			$sx .= '<TH width=60%>'.msg('country_desc');
			$sx .= '<TH>'.msg('country_sample_size');
			
			/* Form */
			$sx .= '
			<style>
				#dd3 { width: 300px; }
				#dd4 { width: 70px; }
				#dd5 { width: 70px; }
			</style>';
			$sx .= '<TR>';
			$sx .= '<TD>';
			$sx .= gets('dd3a',$dd[3],'$Q pais_nome:pais_codigo:select * from ajax_pais where pais_idioma = \'en_US\' and pais_ativo=1 order by pais_nome',mst('country'),0,1,'','form_textarea_full','');
			$sx .= gets('dd4a',$dd[4],'$I4',mst('size'),0,1,'','form_textarea_full','Size','');
			$sx .= '<TD><input type="button" id="country_post" value="'.msg('country_post').'" class="form_submit">';
			$sx .= '</table>';
			$sx .= '</div>';
			
			$cr = chr(13).chr(10);
			$sx .= '<script>'.$cr;
			$sx .= '$("#country_post").click(function() 
				{
					var v1 = $(\'#dd3a\').val();
					var v2 = $(\'#dd4a\').val();
					var site = \'submit_ajax_php\';
					var ok = 1;			
					if (v1.length == 0) { ok = 0; alert(\'Descriction is necessary\'); }
					if (ok == 1)
					{ 
			 		$.ajax({
			 				url: "submit_ajax.php",
			 				type: "POST",
			 				data: { dd1: v1, dd2: v2, dd10: "country" ,dd11: "'.$this->protocol.'", dd12: "DEL" }
			 		 }) 
					.fail(function() { alert("error #01"); })
			 		.success(function(data) { $("#country").html(data); });
					} 
				});
				
			'.$cr;
			$sx .= '</script>'.$cr;
			return($sx);
		}
	function country_list($protocol)
		{
			global $tab_max;
			$sql = "select * from cep_submit_country 
				inner join ".$this->tabela." on ctr_country = pais_codigo
				where ctr_protocol = '".$protocol."' and ctr_ativo = 1
				order by pais_nome";
			$rlt = db_query($sql);
			$it = 0;
			$tot = 0;
			$toti = 0;
			$sx .= '<table width="'.$tab_max.'" class="lt1">';
			$sx .= '<TR>';
			$sx .= '<TH width="5%">'.msg('budget_item');
			$sx .= '<TH>'.msg('country_desc');
			$sx .= '<TH>'.msg('country_sample_size');
			while ($line = db_read($rlt))
				{
					$link = "<A HREF=\"javascript:country_del(".$line['id_ctr'];
					$link .= ",'".checkpost($line['id_ctr'])."');\">";
					$it++;
					$toti = $toti + $line['sorca_unid'];
					$tot = $tot + $line['sorca_unid']*$line['sorca_valor'];
					$sx .= '<TR>';
					$sx .= '<TD align="center">'.$it;
					$sx .= '<TD align="left">'.trim($line['pais_nome']);
					$sx .= '<TD align="center">'.trim($line['ctr_target']);
					$sx .= '<TD align="right" width="10">';
					$sx .= $link;
					$sx .= '<img src="img/icone_remove.png" border=0>';
					$sx .= '</A>';
				}
			$sx .= '</table>';
			
			$s .= chr(13).'<script type="text/javascript">';
			$s .= chr(13).'function country_del(id) {';
			$s .= chr(13).'var $tela = $.ajax({ url: "submit_ajax.php", type: "POST", ';
			$s .= chr(13).'data: { dd0: id, dd10: "country" ,dd12 :"DEL" ,dd11: "'.$protocol.'" }';
			$s .= chr(13).'})';
			$s .= chr(13).'.fail(function() { alert("error #02"); })';
			$s .= chr(13).'.success(function(data) { $("#country").html(data); });';
			$s .= chr(13).'}';
			$s .= chr(13).'</script>';		
			$sx .= chr(13).$s;		
			return($sx);
		}		
	function cp()
		{
			global $messa,$dd;
			$cp = array();	
			array_push($cp,array('$H8','id_pais','',False,True));
			array_push($cp,array('$S80','pais_nome',msg('country_name'),False,True));
			array_push($cp,array('$H8','pais_use','',False,True));
			array_push($cp,array('$H8','pais_codigo','',False,True));
			array_push($cp,array('$O 1:#YES&0:#NO','pais_ativo',msg('ativo'),False,True));
			array_push($cp,array('$H8','pais_idioma','',False,True));
			return($cp);
		}	
		
	function row()
			{
				global $cdf,$cdm,$masc,$messa;
				$cdf = array('id_pais','pais_nome','pais_idioma');
				$cdm = array('cod',msg('country_name'),msg('idioma'));
				$masc = array('','','','SN','','','');
				return(1);				
			}
		function updatex()
			{
				$c = 'pais';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) where $c2='' ";
				$rlt = db_query($sql);
			}
	}
