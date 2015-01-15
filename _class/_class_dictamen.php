<?php
    /**
     * Dictamen
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage dictamen
    */
    
class dictamen
	{
	var $protocol='';	
	var $tabela = "cep_dictamen ";
	
	function le_parecer($id)
		{
			$sql = "select * from cep_parecer 
					inner join cep_protocolos on pr_protocol = cep_protocol
					inner join usuario on cep_pesquisador = us_codigo
					left join parecer_modelo on (pm_decision = pr_situacao) and (pm_type = cep_tipo)
					where  pr_protocol = '".$id."' ";
			$rlt = db_query($sql);
			if ($line = db_read($rlt))
				{
					$this->line = $line;
				}
		}	
		
	function le($id)
		{
			$sql = "select * from ".$this->tabela." 
					inner join cep_protocolos on pr_protocol = cep_protocol
					inner join usuario on cep_pesquisador = us_codigo
					left join parecer_modelo on (pm_decision = pr_situacao) and (pm_type = cep_tipo)
					where  pr_protocol = '".$id."' ";
			$rlt = db_query($sql);

			if ($line = db_read($rlt))
				{
					$this->line = $line;
				}
		}
		
	function updatex()
			{
				$c = 'pm';
				$c1 = 'id_'.$c;
				$c2 = $c.'_codigo';
				$c3 = 5;
				$sql = "update parecer_modelo set $c2 = lpad($c1,$c3,0) where $c2='' ";
				$rlt = db_query($sql);
			}
					
	function row_modelo()
			{
			global $tabela,$sdd;
			global $cdf,$cdm,$masc;

			$tabela = "parecer_modelo";

				$cdf = array('id_pm','pm_name','pm_type','pm_decision','pm_0','pm_1','pm_2','pm_3','pm_4','pm_5','pm_6','pm_7','pm_8');
				$cdm = array('cod',msg('name'),msg('type'),msg('decision'),'p1','p2','p3','p4','p5','p6','p7','p8','p9');
				$masc = array('','','','','SN','SN','SN','SN','SN','SN','SN','SN','SN');
				return(1);				
			}		
	function cp_modelo()
		{
			global $tabela,$sdd,$LANG;
			$tabela = "parecer_modelo";
			$opa = '';
			$ops = array('APR','NOA','NOT','PRO','RET');
			for ($r=0;$r < count($ops);$r++)
				{ $opa .= '&'.$ops[$r].':'.msg('pm_'.$ops[$r]);	}
			
			$opt = '';
			$ops = array('PRO','AME');
			for ($r=0;$r < count($ops);$r++)
				{ $opt .= '&'.$ops[$r].':'.msg('prj_type_'.$ops[$r]);	}

			$cp = array();
			array_push($cp,array('$H8','id_pm','',False,True));
			array_push($cp,array('$H8','pm_approved','',False,True));
			
			array_push($cp,array('$S30','pm_name','',True,True));
			array_push($cp,array('$O : '.$opt,'pm_type','',True,True));
			array_push($cp,array('$H8','pm_codigo','',False,True));
			array_push($cp,array('$O : '.$opa,'pm_decision','',True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_0',msg('dic_pm_0'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_1',msg('dic_pm_1'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_2',msg('dic_pm_2'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_3',msg('dic_pm_3'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_4',msg('dic_pm_4'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_5',msg('dic_pm_5'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_6',msg('dic_pm_6'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_7',msg('dic_pm_7'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_8',msg('dic_pm_8'),True,True));
			array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'pm_accompaniment',msg('accompaniment'),True,True));
			
			return($cp);
		}
	function ged_delete_old($proto)
		{
		global $ged;
		$ged->tabela = 'cep_ged_documento';
		$sql = "update ".$ged->tabela." set doc_ativo = 0
					where doc_tipo = 'DICT' and doc_dd0 = '".$proto."' ";
		$rlt = db_query($sql);
		}
	function save_ged()
		{
			global $ged;
			$filename = $this->filemane;
			$ged->tabela = 'cep_ged_documento';
			$ged->protocol = $this->protocol;
			$ged->file_type = 'DICT';
			$ged->file_name = msg('dictamen').date("Ymd_Hi").'.pdf';
			$ged->file_data = date("Ymd");
			$ged->file_time = date("H:i:s");
			$ged->file_saved = $filename;
			$ged->file_size = filesize($filename);
			$ged->file_versao = 1;
			$ged->save();
		}
		
	function dictamen_recupera()
		{
			global $dd;
			$caae = $dd[1];
			$sql = "select * from cep_protocolos 
					inner join cep_parecer on cep_protocol = pr_protocol 
					where cep_protocol = '$caae' ";
			$rlt = db_query($sql);
			
			if ($line = db_read($rlt))
				{
					$dd[20] = $line['pr_texto_1'];
					$dd[21] = $line['pr_texto_2'];
					$dd[22] = $line['pr_texto_3'];
					$dd[23] = $line['pr_texto_4'];
					$dd[24] = $line['pr_texto_5'];
					$dd[25] = $line['pr_texto_6'];
					$dd[26] = $line['pr_texto_7'];
					$dd[27] = $line['pr_texto_8'];
					$dd[28] = $line['pr_texto_9'];
					$dd[29] = $line['pr_accompaniment'];
					$dd[30] = $line['pr_sitacao'];
					
					$dd[40] = $caae;
					$dd[41] = $line['cep_tipo'];
					$dd[42] = $line['pr_status'];
				}
			return(1);
		}
	function dictamen_save($dd)
		{
			global $include,$ged,$LANG,$messa;
			$ver = round($ver);
			if ($ver == 0) { $ver = 1;}
			$caae = $dd[1];
			$sql = "select * from cep_dictamen where pr_protocol = '$caae' ";
				$rlt = db_query($sql);
			
			$data = date("Ymd"); $hora = date("H:i");
			$situacao = $dd[31];

			if ($situacao=='1')
				{ $situacao = 'F'; } else { $situacao = 'A'; }
			$sta = 'A';
			$dd20 = $dd[20]; $dd21 = $dd[21]; $dd22 = $dd[22];
			$dd23 = $dd[23]; $dd24 = $dd[24]; $dd25 = $dd[25];
			$dd26 = $dd[26]; $dd27 = $dd[27]; $dd28 = $dd[28];
			$dd29 = $dd[29];
			$dd30 = $dd[30];
			$dd40 = $dd[40]; $dd41 = $dd[41]; $dd42 = $dd[42]; 
			$acomp = round($dd29);
			$resultado = $dd[27];

			if ($line = db_read($rlt))
			{
				$sql = "update cep_parecer set 
						pr_texto_1 = '$dd20',
						pr_texto_2 = '$dd21',
						pr_texto_3 = '$dd22',
						pr_texto_4 = '$dd23',
						pr_texto_5 = '$dd24',
						pr_texto_6 = '$dd25',
						pr_texto_7 = '$dd26',
						pr_texto_8 = '$dd27',
						pr_texto_9 = '$dd28',
						pr_status = '$situacao',
						pr_situacao = '$resultado',
						pr_data_emissao = $data,
						pr_accompaniment = $acomp
						where id_pr = ".$line['id_pr'];
				$rlt = db_query($sql);
			} else {
				$sql = "insert into cep_parecer
						(
						pr_protocol, pr_versao, pr_situacao, 
						pr_status, 
						pr_texto_1, pr_texto_2, pr_texto_3,
						pr_texto_4, pr_texto_5, pr_texto_6,
						pr_texto_7, pr_texto_8, pr_texto_9,
						pr_relator, pr_revisor, pr_data,
						pr_hora, pr_log, pr_ativo, 
						pr_data_emissao, pr_ass, pr_accompaniment
						) values (
						'$caae',$ver,'$resultado',
						'$situacao',
						'$dd20','$dd21','$dd22',
						'$dd23','$dd24','$dd25',
						'$dd26','','',
						'','',$data,
						'$hora','',1,
						$data,'',$acomp
						);
						";
				$rlt = db_query($sql);
			}
			
			if ($situacao == 'F') 
					{
						/* 
						 * verifica se nao existe dictamen anterior
						 * create_pdf_dictamen
						 * salva arquivo no GED
						 */
						
						$sql = "select * from cep_dictamen  
								inner join cep_protocolos on cep_caae = pr_protocol
								inner join parecer_modelo on pm_decision = pr_situacao
								inner join usuario on us_codigo = cep_pesquisador
								left join ajax_pais on us_country = pais_codigo
								where pr_protocol = '$caae' ";
						$rlt = db_query($sql);
						if ($line = db_read($rlt))
						{
							//print_r($line);
							$file = 'document';
							$ged->dir($file);
							$file .= '/'.date("Y");
							$ged->dir($file);
							$file .= '/'.date("m");
							$ged->dir($file);
							$file .= '/';
							$destino .= $file.substr($caae,5,10).'_dictamen.pdf';
							
							/* Parametros */
							$dic = $this;
							$dic->line = $line;
							
							$nrp = strzero($line['id_pr'],6);

							//echo '<A HREF="'.$destino.'" target="new">Download</A>';
							require("dictamen_pdf_projeto.php");
						}
						$this->filemane = $destino;
					 	return(2); 
					}
			if ($situacao == 'A') { return(0); }
			
			return(0);
		}
		
	function dictamen_form()
		{
			global $dd,$acao,$cep,$messa,$LANG;
			$sx = '';

			/* recupera tipo do projeto */
			$tipo = $dd[41];
			$sql = "select * from parecer_modelo where pm_type = '$tipo' ";
			$rlt = db_query($sql);
			$fmt = array();
			array_push($fmt,array('','---','00000',
						0,0,0, 
						0,0,0,
						0,0,0,
						0
					));
			while ($line = db_read($rlt))
				{
					array_push($fmt,array(trim($line['pm_name']),$line['pm_decision'],$line['pm_codigo'],
						$line['pm_0'], $line['pm_1'], $line['pm_2'], 
						$line['pm_3'], $line['pm_4'], $line['pm_5'],
						$line['pm_6'], $line['pm_7'], $line['pm_8'],
						$line['pm_accompaniment']
					));
					
				}
			/* JavaScript */
			
			$cpa = array('a','b','c','d','e','f','g','h','i','j');
		
			$ja .= 'function mostra_fields(a,b,c,d,e,f,g,h,i,j) { '.chr(13);		
			for ($rr=0;$rr < count($cpa);$rr++)
				{
					$ja .= 'if ('.$cpa[$rr].' == 1) 
							{ $("#dic'.strzero($rr,3).'").fadeIn("slow"); } else 
							{ $("#dic'.strzero($rr,3).'").fadeOut("slow"); } '.chr(13);
				}	
			$ja .= ' } '.chr(13);						

			/* Mostra formularios */
			$pos = 0;
			
			/* monta formulario Select */
			$sa .= '<input type="hidden" id="dd1" name="dd1" value="'.$dd[1].'">';
			$sa .= '<select id="dd27" name="dd27">';
			$jb = '';
			$jb2 = '';
			for ($r=0;$r < count($fmt);$r++)
				{
					$chk = '';		
					if ($dd[27] == $fmt[$r][1]) { $chk = 'selected'; }			
					$sa .= '<option value="'.$fmt[$r][1].'" '.$chk.'>';
					$sa .= msg($fmt[$r][0]);
					$sa .= '</option>';
					
					/* monta comando java show */
					$jb1 = 'if (ask == "'.$fmt[$r][1].'") { mostra_fields(';
					for ($ra = 0;$ra < 9;$ra++) {$jb1 .= $fmt[$r][$ra+3].','; }
					$jb1 .= $fmt[$r][12].'); } '.chr(13);
					
					if ($chk == 'selected')
						{
							$jb2 .= 'var x = mostra_fields(';
							for ($ra = 0;$ra < 9;$ra++) {$jb2 .= $fmt[$r][$ra+3].','; }
							$jb2 .= $fmt[$r][12].'); '.chr(13);
						}	
					
					$jb .= $jb1;
				}			
			$sa .= '</select>';			
			$sx .= $sa;
			$sx .= '<table class="table_proj2" width="100%">';
			
			for ($r=0;$r < 9;$r++)
				{
				$stl = '';		
				if ($fmt[$pos][$r+3]==0) { $stl = 'style="display: none;"'; }
				$sx .= chr(13);
				$sx .= '<TR><TD colspan=2 class="lt0"><div id="dic'.strzero($r,3).'" '.$stl.'>';
				$sx .= msg('dictamen_'.$r).'<BR>';
				$sx .= '<textarea rows=6 cols=80 style="width: 96%;" name="dd'.($r+20).'" id="dd'.($r+20).'">';
				$sx .= $dd[($r+20)];
				$sx .= '</textarea>';
				$sx .= '</div>';
				}
			/* Acompanhamento */
			$sx .= chr(13);
			$acop = array(array('',''),array(180,msg('semiannual')),array(365,msg('annual')),array(-1,msg('end_of_the_investigation')));
			$hd = 'style="display: none;"';
			
			/*
			 * Acompanhamento 
			 **/
			
			$sx .= '<TR><TD colspan=2 class="lt0"><div id="dic009" 	'.$hd.'>';			
			$sx .= msg('accompaniment').' ';
			
			$sx .= chr(13);
			$sx .= '<select id="dd29" name="dd29">';
			
			for ($r=0;$r < count($acop);$r++)
				{
					$chk = '';
					$sx .= chr(13);
					if ($dd[29]==$acop[$r][0]) { $chk = 'selected'; }
					$sx .= '<option value="'.$acop[$r][0].'" '.$chk.'>';
					$sx .= msg($acop[$r][1]);
					$sx .= '</option>';
				}
			$sx .= chr(13).'</select>';

			/* Botao */
			$sx .= chr(13);
			$sx .= '<TR><TD colspan=2 class="lt0"><div id="dicfim" style="'.$hid.'">';						
			$bto = msg('save_dictamen');
			$sx .= '<BR>';
			$sx .= '<input type="checkbox" value="1" id="dd31">';
			$sx .= ' '.msg('final_version');					
			$sx .= '<BR>';			
			$sx .= '<input type="button" value="'.$bto.'" id="save_dictamen" class="botao-submit">';					
				
			$sx .= chr(13).'</table>';
			
			
			$sx .= chr(13).chr(13);
			$sx .= '<script>'.chr(13);
			$sx .= $jb2;
			$ss .= ' var ask=2; '.chr(13);
			$sx .= $ja;
			
			$sx .= chr(13);
			$sx .= '$("#dd27").change(function () { '.chr(13);
			$sx .= 'var ask = $("#dd27").val(); '.chr(13);
			$sx .= $jb;			
			$sx .= '});'.chr(13);
			$sx .= '</script>'.chr(13);
			
			$sx .= '
			<script>
				$("#save_dictamen").click(function() 
				{	
					var v1 = $(\'#dd1\').val();
 					var v20 = $(\'#dd20\').val();
					var v21 = $(\'#dd21\').val();
					var v22 = $(\'#dd22\').val();
					var v23 = $(\'#dd23\').val();
					var v24 = $(\'#dd24\').val();
					var v25 = $(\'#dd25\').val();
					var v26 = $(\'#dd26\').val();
					
					var v27 = $(\'#dd27\').val();
					var v28 = $(\'#dd28\').val();
					var v29 = $(\'#dd29\').val();
					
					var v30 = $(\'#dictamen\').val();
					var v31 = $(\'#dd31\').is(":checked");
					if (v31==true)
						{ v31 = 1; }
						else
						{ v31 = 0; }
					var ok = 1;
					if (v20.length == 0) { ok = 0; alert(\'Descriction is necessary\'); }
					if (v21.length == 0) { ok = 0; alert(\'Quant. is necessary\'); }
					if (v22.length == 0) { ok = 0; alert(\'Unit value is necessary\'); }					
					ok = 1;
					
					if (ok == 1)
					{
			 			$.ajax({
			 					url: "dictamen_ajax.php",
			 					type: "POST",
			 					data: { dd1: v1,
			 							dd20: v20, dd21: v21, dd22: v22,
			 							dd23: v23, dd24: v24, dd25: v25,
			 							dd26: v26, dd30: v30, dd31: v31,
			 							dd27: v27, dd28: v28, dd29: v29,
			 							dd31: v31,
			 							dd1: v1, acao: "gravar"
									  }
			 		 	}) 
						.fail(function() { alert("error"); })
			 			.success(function(data) { $("#dictame").html(data); });
					}  
				}); 			
			</script>
			';			
			
			return($sx);
		}

	function create_pdf($caae,$save=0)
		{
			global $include,$ged;
			$ged->dir('document');
			$ged->dir('document/'.date("Y"));
			$ged->dir('document/'.date("Y").'/'.date("m"));
			$this->filemane = 'document/'.date("Y").'/'.date("m").'/'.$caae.substr(md5(date("YmdHis").$caae),5,5).'_dictamen.pdf';
			$destino = $this->filemane;
			
			$dic = new dictamen;
			$dic->le_parecer($caae);

			require("dictamen_pdf_projeto.php");
			$sx = '<A HREF="dictamen_pdf.php?dd1='.$caae.'" target="new">';
			echo $sx;
		}
		
	function dictame($caae)
		{
			
		}			
	}
?>
