<?php
    /**
     * Comunications
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage comunications
    */
class comunication
	{
		var $email;
		var $protocolo;
		var $tabela = 'cep_email';
		
		function show_resume()
			{
				global $messa, $edit_mode;
				$sx .= msg('show_comunication').$this->total_messages();
				return($sx);
			}
		
		function total_messages()
			{
				global $messa, $edit_mode;
				$sql = "select count(*) as total from ".$this->tabela." where email_protocolo = '".$this->protocolo."' ";
				$xrlt = db_query($sql);
				$xline = db_read($xrlt);
				$tot = round($xline['total']);
				if ($tot > 0)
					{
						$sa = ' - '.$tot.' <B>'.msg('message').'</B>';
					} else {
						$sa = ' - '.msg('no_messages');		
					}
				
				return($sa);		
			}
		function display()
			{
				global $edit_mode, $date;
				$sql = "select * from ".$this->tabela." 
						left join usuario on email_log = us_codigo
						where email_protocolo = '".$this->protocolo."' 
						order by email_id_msg, email_data desc, email_hora desc ";
				$rlt = db_query($sql);
				
				$sx = '<TABLE width=100% class="lt1" border=0 cellpadding=3 cellspacing=0>';
				while ($line = db_read($rlt))
					{
						$sx .= '<TR><TD align="left"><fieldset><legend>';
						$sx .= msg("message_poted").': '.$date->stod($line['email_data']).' '.$line['email_hora'].'</legend>';
						$sx .= '<TT><I>Subject: '.$line['email_assunto'].'</I>';
						$sx .= '<BR>Message: '.mst($line['email_texto']);
						$sx .= '</fieldset><HR width="50%" size=1>';
					}
				$sx .= '</table>';
				return($sx);
				
			}
			
		function post_new_message($email1,$email2)
			{
				global $edit_mode;
				$sx .= '<div id="postnm"  style="cursor: pointer;">'.msg('post_new_message').'</div>';
				$sx .= '<div id="posthw" style="display: none;">
					<table width="98%" class="lt1" border=0 cellpadding=0 cellspacing=0 bgcolor="#F0F0F0">';				
				$sx .= $this->send_form($email1,$email2);
				$sx .= '<TD align="right" width="25"><img src="img/icone_close.png" height="25" id="posthr" style="cursor: point;">';
				$sx .= '</table></div>';

				$sx .= '<script>
						$("#postnw").click(function () 
							{ 
							$("#posthw").fadeIn("slow");
							$("#postnw").hide();
						} );
						$("#postnm").click(function () 
							{ 
							$("#postnm").fadeOut("slow");
							$("#posthw").fadeIn("slow");
						} );	
						$("#posthr").click(function () 
							{ 
							$("#posthw").fadeOut("slow");
							$("#postnm").fadeIn("slow");
						} );
						</script>'.chr(13);
				return($sx);				
			}


		function email_save($cont,$sub)
			{
				$data = date("Ymd");
				$hora = date("H:i:s");
				
				$sql = "insert into ".$this->tabela."
					(email_research, email_data, email_hora,
					email_assunto, email_texto, email_protocolo, 
					email_status, email_log, email_id_msg, 
					email_read ) values (
					'$this->pesquisador',$data,'$hora',
					'$sub','$cont','$this->protocolo',
					'A','$user->user_codigo','',
					'A') ";
					$rlt = db_query($sql);
				return(1);	
			}
		function send_form($email1,$email2)
			{
			global $dd,$acao,$institution_name;
			global $edit_mode;
			
			if (strlen($acao) > 0)
				{
					if ((strlen($dd[45]) > 0) and (strlen($dd[46]) > 0))
						{
							/* enviar e-mail */
							$subject = $dd[45];
							$text = $dd[46];
							$email = 'renefgj@gmail.com';							
							enviaremail($email,'',$subject,$text);
							
							if (strlen($email1) > 0)
								{ enviaremail($email1,'',$subject,$text); }
							if (strlen($email2) > 0)
								{ enviaremail($email2,'',$subject,$text); }
							
							$this->email_save($dd[46],$dd[45]);
							$sa .= '<script> alert("email enviado") </script>';
							$dd[45] = '';
							$dd[46] = '';		
						}
					
				}
			$sa .= '<TR valign="top"><TD>
				<form method="post" action="'.page().'">
				<input type="hidden" name="dd1" value="'.$dd[1].'">
				<input type="hidden" name="dd2" value="'.$dd[2].'">
				<input type="hidden" name="dd3" value="'.$dd[3].'">
				<input type="hidden" name="dd90" value="'.$dd[90].'">
				';
			$subj = $institution_name.' - '.$this->protocolo;
			$sa .= '<TABLE class="lt0">';
			$sa .= '<TR valign="top"><TD>'.msg('mail_subject').'<TD>';
			$sa .= '<input type="hidden" name="dd45" size=60 maxlength=100 value="'.$subj.'">'.$subj;
			$sa .= '<TR valign="top"><TD>'.msg('mail_content').'<TD>';
			$sa .= '<textarea name="dd46" cols=50 rows=5 style="width: 99%;" >'.$dd[46].'</textarea>';
			$sa .= '<TR><TD colspan=2>';
			$sa .= '<input type="submit" name="acao" value="'.msg('send_mail').'">';
			$sa .= '</table>';
			$sa .= '</form>';
			return($sa);
			}
	}
