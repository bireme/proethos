<?php
/*
 * Sistema de e-mail
 */
$admin_nome = 'Rene F. Gabriel';
$email_adm = 'rene.gabriel@pucpr.br';

require_once ("libs/email/PHPMailerAutoload.php");

function enviaremail($para, $blank, $titulo, $texto) {
	global $email_from, $email_from_name, $email_smtp, $email_pass, $email_user, $email_auth, $email_debug, $email_replay;

	if (strlen($email_from) == 0) {
		echo '<H1>Erro #120#</h1>';
		echo '<PRE>';
		echo 'Parametros nao informados:
			/* Dados do enviador */
			$email_from = \'\';			/* e-mail do enviador / replay */
			$email_from_name = \'\';	/* Nome do enviador */
			
			/* Tipo de envio */
			$email_auth = \'\'; 			/* ou AUTH ou MAIL */
			
			/* Dados da conta do enviador - obrigatorio para AUTH */
			$email_smtp = \'\';			/* servidor de SMTP */
			$email_user = \'\';			/* usuario da conta do enviador */
			$email_pass = \'\';			/* senha da conta do enviador */	
			
			';
		echo '</pre>';
		exit ;
	}
	switch ($email_auth) {
		case 'AUTH' :
			$mail = new email;
			$mail -> titulo = $titulo;
			$mail -> texto = $texto;

			$mail -> email = $email_from;
			$mail -> email_replay = $email_replay;
			$mail -> email_name = $email_from_name;

			$mail -> email_user = $email_user;
			$mail -> email_pass = $email_pass;
			$mail -> email_smtp = $email_smtp;
			
			$mail -> debug = round($email_debug);

			$mail -> to = $para;
			$mail -> method_2_mail();
			break;

		default :
			$mail = new email;
			$mail -> titulo = $titulo;
			$mail -> texto = $texto;

			$mail -> email = $email_from;
			$mail -> email_replay = $email_replay;
			$mail -> email_name = $email_from_name;

			$mail -> email_user = $email_user;
			$mail -> email_pass = $email_pass;
			$mail -> email_smtp = $email_smtp;
			
			$mail -> debug = round($email_debug);

			$mail -> to = $para;			
			$mail -> method_1_mail();
			break;
	}
}


function checaemail($chemail) {
	$result = count_chars($chemail, 0);
	if (($result[64] == 1) and ($result[32] == 0) and ($result[32] == 0) and ($result[13] == 0) and ($result[10] == 0)) {
		$xerr = True;

		if (strpos($chemail, '!')) { $xerr = False;
		}
		if (strpos($chemail, '@.')) { $xerr = False;
		}
	} else {$xerr = False;
	}

	if ($chemail[strlen($chemail) - 1] < 'a') { $xerr = false;
	}
	return ($xerr);
}

/* Classe do e-mail */

class email {
	var $titulo;
	var $texto;
	var $to = '';
	var $cc = array();
	var $cco = array();
	
	var $debug = 0;

	/* Dados do enviador */
	var $email = 'rene@sisdoc.com.br';
	var $email_replay = '';
	var $email_name = '';

	/* Dados do enviador SMTP */
	var $email_user = '';
	var $email_pass = '';
	var $email_smtp = '';

	function method_1_mail() {
		/* Recupera dados */
		$from = $this -> email;
		$form_name = $this -> email_name;
		$replay = $this -> email_replay;
		$email_to = $this -> to;
		$title = $this -> titulo;
		$body = $this -> texto;

		$headers = '';
		$headers .= "To: " . $e1 . " \n";
		$headers .= "From: " . $form_name . " <" . $form . "> \n";
		$headers .= "Mime-Version: 1.0 \n";
		//	$headers .= "Priority: Normal \n";
		//	$headers .= "Reply-To: " .$email_adm. " \n";
		//	$headers .= "Return-Path: ".$email_adm." \n";
		//	$headers .= "Subject: ".$subject." \n";
		//	$headers .= "X-Assp-Envelope-From:".$email_adm." \n";
		$headers .= 'Content-Type: text/html; charset="iso-8859-1"' . " \n";

		$headers = '';
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "To: " . $e1 . " \n";
		$headers .= "Reply-To: " . $from . " \n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: " . $form_name . " <" . $from . "> \r\n";

		//	$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">'."\n".$body;
		mail($to, $subject, $body, $headers) or die("<font color=red >Erro de envio do e-mail para ".$email_to.'</font>');
	}

	function method_2_mail() {

		/* Recupera dados */
		$smtp = $this -> email_smtp;
		$user = $this -> email_user;
		$pass = $this -> email_pass;
		$from = $this -> email;
		$form_name = $this -> email_name;
		$replay = $this -> email_replay;
		$email_to = $this -> to;
		$title = $this -> titulo;
		$body = $this -> texto;

		/* Iniciar objeto */
		$mail = new PHPMailer;
		$mail -> isSMTP();
		$mail -> SMTPDebug = 0;
		$mail -> Debugoutput = 'html';
		$mail -> Host = $smtp;
		$mail -> Port = 25;
		$mail -> SMTPAuth = true;
		$mail -> Username = $user;
		$mail -> Password = $pass;
		$mail -> setFrom($from, $from_name);

		/* From name */
		$mail -> FromName = $form_name;
		$mail -> From = $from;

		//Set an alternative reply-to address
		$mail -> addReplyTo($replay, htmlspecialchars($from_name));

		//Set who the message is to be sent to
		$mail -> addAddress($email_to, $email_to);

		//Set the subject line
		$mail -> Subject = $title;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail -> msgHTML($message_sample, dirname(__FILE__));
		//Replace the plain text body with one created manually
		$mail -> Body = $body;
		//$mail -> AltBody = $body; //
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail -> send()) {
			return ("Mailer Error: " . $mail -> ErrorInfo);
		} else {
			return ("Message sent!");
		}

	}

	/*
	 * e-mail check
	 */
	function email_check($chemail) {
		$result = count_chars($chemail, 0);
		if (($result[64] == 1) and ($result[32] == 0) and ($result[32] == 0) and ($result[13] == 0) and ($result[10] == 0)) {
			$xerr = True;

			if (strpos($chemail, '!')) { $xerr = False;
			}
			if (strpos($chemail, '@.')) { $xerr = False;
			}
		} else {$xerr = False;
		}

		if ($chemail[strlen($chemail) - 1] < 'a') { $xerr = false;
		}
		return ($xerr);
	}

	/*
	 * Format the e-mail
	 */
	function format_email($email, $name) {
		$name = trim($name);
		$email = trim($email);
		if (strlen($name) > 0) {
			$sx = $name . ' <' . $email . '>';
		} else {
			$sx = $email;
		}
		return ($sx);
	}


	function structure() {
		$sql = "
					create table MAIL
						{
							id_ml serial not null,
							ml_idmsg char (15),
							ml_de char(8),
							ml_para char(8),
							ml_titulo text,
							ml_texto text,
							
							ml_enviado integer,
							ml_enviado_hora char(8),
							
							ml_lido integer,
							ml_lido_hora char(8),
							
							ml_importancia integer,
							ml_excluido integer,
							
							ml_enviado integer,
							ml_caixa char(1)
						}
				";
		$rlt = db_query($sql);
	}

}
?>
