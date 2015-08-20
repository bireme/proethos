<?php
    /**
     * Ethics Comment
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage cep_comment
    */
class cep_comment
	{
		var $protocol;
		var $version;
		var $codigo;
		var $user;
		var $comment;
		var $avaliation;
		var $tabela = 'cep_comment';
				
		function comment_save()
			{
				global $user,$ss;
				
				$comment = $this->comment;
				$codigo = $this->codigo;
				$data = date("Ymd");
				$hora = date("H:i:s");
				$aval = $this->avaliation;
				$user = strzero($ss->user_codigo,7);

				$sql = "select * from ".$this->tabela;
				$sql .= " where cepc_codigo='$codigo' and 
					cepc_user='$user' and cepc_comment = '$comment' ";
				$rlt = db_query($sql);
				if (!($line = db_read($rlt)))
					{
					$sql = "insert into ".$this->tabela." 
						(cepc_codigo,cepc_user,cepc_comment,
						cepc_data, cepc_hora, cepc_avaliation )
						values
						('$codigo','$user','$comment'
						,$data,'$hora','$aval')";
					$rlt = db_query($sql);
					}
				$sql = "select cepc_avaliation, count(*) as total 
					from ".$this->tabela." where cepc_codigo = '$codigo' 
					group by cepc_avaliation ";
				$rlt = db_query($sql);
				
				$p1=0; $p2=0;
				while ($line = db_read($rlt))
					{
						if ($line['cepc_avaliation']=='1') {$p1 = $p1 + $line['total']; }
						if ($line['cepc_avaliation']=='0') {$p2 = $p2 + $line['total']; }
					}					
				$sql = "update cep_protocolos set cep_comment_pos=$p1, cep_comment_neg=$p2 where cep_codigo = '$codigo' ";
				$rlt = db_query($sql);
				
				return(1);
			}
		
		function comment_form()
			{
				global $dd,$ss;
				$us = strzero(round($ss->user_id),7);
				
				$sx = ''; $sxf = '';
				if ((strlen($dd[1]) > 0))
					{
						if  (strlen($dd[2])== 0)
							{
								$sxf = '<script>'.chr(13);
								$sxf .=  " alert('".msg('need_comment_type')."');";
								$sxf .=  '</script>'.chr(13);
							} else {
								$this->comment = $dd[1];
								$this->avaliation = $dd[2];
								$this->user = $us;
								$this->comment_save();
								$dd[1]='';
								$dd[2]='';
								redirecina(page());
							}
					}
				
				$disp1 = 'display: none;';
				$disp2 = 'display: block;';
				if (strlen($dd[1]) > 0)
					{
						$disp2 = 'display: none;';
						$disp1 = 'display: block;';						  
					}
					
				$sx .= '<div id="posted" style="'.$disp1.'">';
				$sx .= '<form method="post" action="'.page().'">';
//				$sx .= '<input type="hidden" name="dd0" value="'.$dd[0].'">'.chr(13);
//				$sx .= '<input type="hidden" name="dd90" value="'.$dd[90].'">'.chr(13);
				
				$sx .= '<table width="98%">';
				$sx .= '<TR><TD>';
				$sx .= msg('comment_post').'<BR>';
				$sx .= '<TR><TD><textarea name="dd1" cols="80" rows="5">';
				$sx .= $dd[1];
				$sx .= '</textarea>';
				$sx .= '<TR><TD>';
				
				/** Avaliation **/
					/* $sx .= msg('comment_type').':';
					
					$chk1 = ''; $chk2 = '';
					if ($dd[2]=='1') { $chk1 = 'checked'; }
					if ($dd[2]=='0') { $chk2 = 'checked'; }
					
					/** Radio **/		
					/** com avalia��o		
					$sx .= '<input type="radio" value="1" name="dd2" '.$chk1.'>';
					$sx .= '<img src="img/icone_coment_ok.png">';
	
					$sx .= '<input type="radio" value="0" name="dd2" '.$chk2.'>';
					$sx .= '<img src="img/icone_coment_nook.png">';
					**/
					
				/** sem avalia��o **/
				$sx .= '<input type="hidden" value="1" name="dd2" >';
				/**  **/
				$sx .= '<BR><input type="submit" value="'.msg('comment_submit').'">';
				$sx .= '</table>';
				$sx .= '</form>';
				$sx .= '</div>';
				/** **/
				$sx .= '<input id="mst" type="button" value="'.msg('comment_add',1).'" onclick="mostrar();"  style="'.$disp2.'">';
				$sx .= chr(13).'<script>
					      $("#mst").click(function () {
					      		$("#posted").fadeIn("slow"); 
						   		$("#mst").fadeOut("slow"); 
						  }); 
						';				
				$sx .= chr(13).'</script>';
				return($sx.$sxf);
			}
		
		function comment_display()
			{
				$sql = "select * from ".$this->tabela." ";
				$sql .= " left join usuario on cepc_user = us_codigo ";
				$sql .= " where cepc_codigo = '".$this->codigo."' ";
				$sql .= " order by cepc_data desc, cepc_hora desc ";
				
				$rlt = db_query($sql);
				$totc = 0;
				$sx .= '<table class="bdcomment" width="100%" aling="center">';
				$sx .= '<TR class="bdcomment_hd"><TD colspan=2 class="lt4">'.msg('comments');
				while ($line = db_read($rlt))
					{
						$totc++;
						$she = trim($line['us_genero']);
						$sx .= '<TR valign="top">';
						$sx .= '<TD width=50 rowspan=2>';
						if ($she != 'W')
							{ $sx .= '<img src="img/icone_noimage_he.png" height=80 >'; }
							else
							{ $sx .= '<img src="img/icone_noimage_she.png" height=80 >'; }
							
						$sx .= '<TD>';
						$sx .= '<B><I>'.$line['us_nome'].'</B></I><BR>';
						$sx .= '<font class="lt1">';
						$sx .= $line['cepc_comment'];
						$sx .= '<TR valign="bottom"><TD>';
						$ava = $line['cepc_avaliation'];
						/* if ($ava == '1') { $sx .= '<img src="img/icone_coment_ok.png">'; } */
						/* if ($ava == '0') { $sx .= '<img src="img/icone_coment_nook.png">'; } */
						$sx .= '<font class="lt0">&nbsp;'.stodate($line['cepc_data']).' '.$line['cepc_hora'];
						$sx .= '<TR><TD style="background-color: #FFFFFF" colspan=2>';
					}
				$sx .= $this->comment_form();
				$sx .= '</table>';
				return($sx);
			}	
		
		function strucuture()
			{
				$sql = "create table cep_comment
					(
					id_cepc serial NOT NULL,
					cepc_codigo char(7),
					cepc_user char(7),
					cepc_comment text,
					cepc_data int8,
					cepc_hora char(8),
					cepc_avaliation char(1)					
					)";
				$rlt = db_query($sql);
				
			}
	}
?>
