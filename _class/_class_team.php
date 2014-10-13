<?php
 /**
  * Team
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v0.12.07
  * @package Class
  * @subpackage team
 */
class team
	{
		var $protocol;
		var $tabela = 'institutions';
		var $erro;
		
		function author_exist($email)
			{
				$sql = "select * from usuario where us_email = '".$email."' ";
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{ return($line['us_codigo']); } else { return(-1); }
			}
		
		function team_form_add()
			{
				$sx = '';
				$sx .= '<div id="newuser" style="display: none; ">' ;
				$sx .= '	<table class="table_normal">';
				$sx .= '	<TR><TD colspan=3>';
				$sx .= '<img src="img/icone_alert.png" align="left">';
				$sx .= 		msg('new_author_inf');
				$sx .= '	<TR>';
				$sx .= '	<TD colspan=2>';				
				$sx .= '	<NOBR>'.msg("email_inform");
				$sx .= '	<TR><TD>';
				$sx .= '	<input type="text" size="50" maxlength=100 id="email_author" style="width: 98%;">';
				$sx .= '	<TD>';
				$sx .= '	<input type="button" id="button_author" value="'.msg('new_author').'" class="botao-submit">';
				$sx .= '	</table>';
				$sx .= '</div>';
				
				$sx .= '<div id="newuser_bt">';
				$sx .= '<input type="button" id="newuser_form" value="'.msg('add_new_member').'" class="botao-submit">';
				$sx .= '</div>';
							
				$sx .= chr(13).'<script type="text/javascript">';
				$sx .= chr(13).'$("#button_author").click(function() {';
					$sx .= chr(13).'var email=$("#email_author").val(); ';
					$sx .= chr(13).'var $tela = $.ajax({ url: "'.page().'?ddx='.date("Yhsi").'", type: "POST", ';
					$sx .= chr(13).'data: { dd11: "'.$this->protocol.'", dd10: "add" ,dd12: email }';
					$sx .= chr(13).'})';
					$sx .= chr(13).'.fail(function() { alert("error"); })';
 					$sx .= chr(13).'.success(function(data) { $("#team").html(data); }); ';
				$sx .= chr(13).'});';
				$sx .= chr(13).'</script>';	
				
				$sx .= chr(13).'<script type="text/javascript">';
				$sx .= chr(13).'$("#newuser_form").click(function() {';
				$sx .= chr(13).'	$("#newuser_bt").hide();';
				$sx .= chr(13).'	$("#newuser").show();';
				$sx .= chr(13).' }); ';	
				$sx .= chr(13).'</script>';							
				return($sx);
			}

		function team_delete_member($id,$protocol,$table = "cep_submit_team")
			{
				$id = round($id);
				$err = '';
				$sql = "select * from ".$table." where 
						ct_protocol = '$protocol' and id_ct = $id ";
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
				{
					if ($line['ct_type']=='C')
						{
							$err = msg('contact_can_not_removed'); 
						}
				}
				if (strlen($err)==0)
					{
					$sql = "delete from ".$table." where 
							ct_protocol = '$protocol' and id_ct = $id
					";
					$rlt = db_query($sql);
					}
				$this->erro = $err;					
				return(1);
			}
			
		function team_insert_author($author,$protocol,$table,$type='N')
			{
				$sql = "select * from $table
						where ct_protocol = '$protocol'
						and ct_author = '$author'
						order by ct_type
				";
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
						$this->erro = msg('author_already_registered');
						return(0);
					} else {
						$data = date("Ymd");
						/* verifica se eh o primero nome e insere como contato */
						$sql = "select count(*) as total from ".$table." where ct_protocol = '$protocol' ";
						$rlt = db_query($sql);
						if ($line = db_read($rlt))
							{ $total = round($line['total']); } else { $total = 0; }
						if ($total == 0) {$type = 'C'; }
						$sql = "insert into ".$table."
								( ct_protocol, ct_author, ct_type,
									ct_data, ct_ativo
								) values (
									'$protocol','$author','$type',
									$data,1
								)
						";
						$rlt = db_query($sql);
						return(1);
					}
				return(0);				
			} 
			
		function team_contact($id,$protocol,$table="cep_submit_team")
			{
				$sql = "update ".$table." set ct_type = 'N' 
							where ct_type = 'C' and ct_protocol = '$protocol'
				";
				//echo '<BR>'.$sql;
				$rlt = db_query($sql);
				$sql = "update ".$table." set ct_type = 'C' 
							where id_ct=$id and ct_protocol = '$protocol'
				";
				$rlt = db_query($sql);
				//echo '<BR>'.$sql;
				return(1);
			}
		
		function team_list($protocol,$table = 'cep_submit_team')
			{
				$tot = 0;

				$sx .= '<table class="table_proj" width="100%">';
				$sx .= '<TR>';
				$sx .= '<TH width="46%">'.msg('author_name');
				$sx .= '<TH width="30%">'.msg('email');
				$sx .= '<TH width="20%">'.msg('country');
				$sx .= '<TH width="4%">'.msg('contact');
				
				$sql = "select * from $table
						inner join usuario on ct_author = us_codigo
						left join ajax_pais on us_country = pais_codigo
						where ct_protocol = '$protocol'
						order by ct_type, id_ct
				";

				$rlt = db_query($sql);
				while ($line = db_read($rlt))
					{
						$sx .= '<TR>';
						$sx .= '<TD>';
						$sx .= $line['us_nome'];
						$sx .= '<TD>';
						$sx .= $line['us_email'];
						$sx .= '<TD>';
						$sx .= $line['pais_nome'];
						$sx .= '<TD align="center">';
						$con = $line['ct_type'];
						if ($con=='C')
							{ $sx .= msg('yes'); } 
							else 
							{
								$sx .= '<img src="img/icone_contact.png" onclick="remove_author('.$line['id_ct'].',23);" title="'.msg('contact_active').'" width="20">';								
								$sx .= '&nbsp;'; 
							}
						$sx .= '<td>';
						$sx .= '<img src="img/icone_remove.png" onclick="remove_author('.$line['id_ct'].',12);">';
					}
					
				$sx .= '<script>'.chr(13);
				$sx .= '
							function remove_author(id,fc)
								{
								if (fc == 12) { fc="del"; }
								if (fc == 23) { fc="con"; }
								var $tela = $.ajax({ url: "'.page().'", type: "POST", 
									data: { dd11: "'.$this->protocol.'", dd10: fc ,dd12: id }
									})
									.fail(function() { alert("error"); })
 									.success(function(data) { $("#team").html(data); });
								}
						';
				
				$sx .= '</script>'.chr(13);
				if ($tot = 0)
					{
						$sx .= '<TR><TD colspan=2><center><font color="red">'.msg('no_author');
					}
				
				$sx .= '</table>';
				return($sx);
			}
		function form_team()
			{
				$sx .= '<table width="100%">';
				$sx .= '<TR><TD colspan=4>'.msg('members');
				$sx .= '<TR><TD><input type="text" name="campo_estado" id="campo_estado" />';
				$sx .= '</table>';
				
				return($sx);
			}
			
		function dados_lista()
			{
				return('');
			}
			
		function lista()
			{
				$sql = "select * from ".$this->tabela." where it_ativo = 1 ";
				$sql .= " order by it_nome ";
				$rlt = db_query($sql);
				$sx = array();
				while ($line = db_read($rlt))
					{
						array_push($sx,array($line['it_codigo'],trim($line['it_nome'])));
					}
				return($sx);
			}
		function lista_action()
			{
				$sql = "select * from institution_action where ia_ativo = 1 ";
				$sql .= " order by ia_descricao ";
				$rlt = db_query($sql);
				$sx = array();
				while ($line = db_read($rlt))
					{
						array_push($sx,array($line['ia_codigo'],trim($line['ia_descricao'])));
					}
				return($sx);
			} 
		function cp()
			{
				$cp = array();
				array_push($cp,array('$H8','id_it','',False,True));
				array_push($cp,array('$H8','it_codigo','',False,True));
				array_push($cp,array('$S100','it_nome','',False,True));
				array_push($cp,array('$S40','it_nome_abrev','',False,True));
				array_push($cp,array('$R I:'.msg('institution').'&P:'.msg('personal'),'it_tipo','',False,True));
				array_push($cp,array('$H8','it','',False,True));
				array_push($cp,array('$H8','it','',False,True));
				return($cp);
			}	
	}
?>
