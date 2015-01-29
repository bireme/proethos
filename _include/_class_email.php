<?php
/**
 * Header
 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com>
 * @access public
 * @version 0.15.03
 * @package INCLUDEs
 * @subpackage E-mail
 */

require_once ("libs/email/PHPMailerAutoload.php");

/* Verifica se nao existe esta funcao criada */
if (!function_exists('enviaremail')) {
	function enviaremail($to = '', $a2 = '', $subject = '', $messagem = '', $a5 = '', $a6 = '', $a7 = '') {
		global $hd;

		/* Method 2 */
		$type = $hd -> email_type;
		
		if ($type == 'AUTH') {
			$mail = new PHPMailer;
			$mail -> isSMTP();

			$smtp = trim($hd -> email_smtp);
			$from = trim($hd -> email);
			$replay = trim($hd -> email_replay);
			$pass = trim($hd -> email_pass);
			$from_name = $hd -> email_name;
			$email_to = $dd[0];

			$mail -> SMTPDebug = 0;
			$mail -> Debugoutput = 'html';
			$mail -> Host = $smtp;
			$mail -> Port = 25;
			$mail -> SMTPAuth = true;
			$mail -> Username = $from;
			$mail -> Password = $pass;
			$mail -> setFrom($from, $from_name);
			$mail -> FromName = $from_name;
			$mail -> From = $from;

			if (strlen($replay) > 0)
				{
					$mail -> addReplyTo($from, $from_name);
				} else {
					$mail -> addReplyTo($from, $from);		
				}
			
			$mail -> addAddress($to, '');
			$mail -> Subject = $subject;
			$mail -> msgHTML($messagem, dirname(__FILE__));
			$mail -> AltBody = 'This is a plain-text message body';
			if (!$mail -> send()) {
				//echo "Mailer Error: " . $mail -> ErrorInfo;
			} else {
				//echo "Message sent!";
			}
		}

		if ($type == 'MAIL') {
			$mail = new PHPMailer;
			$mail -> isSMTP();

			$smtp = trim($hd -> email_smtp);
			$from = trim($hd -> email);
			$replay = trim($hd -> email_replay);
			$pass = trim($hd -> email_pass);
			$from_name = $hd -> email_name;
			$email_to = $dd[0];

			$mail -> SMTPDebug = 0;
			$mail -> Debugoutput = 'html';
			$mail -> Host = $smtp;
			$mail -> Port = 25;
			$mail -> SMTPAuth = true;
			$mail -> Username = $from;
			$mail -> Password = $pass;
			$mail -> setFrom($from, $from_name);
			$mail -> addReplyTo($from, $from_name);
			$mail -> addAddress($to, '');
			$mail -> Subject = $subject;
			$mail -> msgHTML($messagem, dirname(__FILE__));
			$mail -> AltBody = 'This is a plain-text message body';
			if (!$mail -> send()) {
				//echo "Mailer Error: " . $mail -> ErrorInfo;
			} else {
				//echo "Message sent!";
			}
		}

	}

}

class email {
	var $user_email = '';
	var $user_name = '';
	var $user_password = '';
	var $user_smtp = '';

	var $to_email;
	var $to_name;

	var $replay_email;
	var $replay_name;

	var $header;
	var $subject;
	var $message;
	var $priority = 0;

	var $monitor = 0;
	var $method = 'A';
	/* A-Authenticado; N-Sem autenticar */

	function cab($assunto, $texto) {
		global $dd, $acao, $email;
		$sx .= '<table width="100%" class="noprint">
						<TR><TD><form method="get" action="' . page() . '">
						<TD><input type="hidden" name="dd0" value="' . $dd[0] . '">
						    <input type="hidden" name="dd1" value="' . $dd[1] . '">
						    <input type="hidden" name="dd2" value="' . $dd[2] . '">
						    <input type="hidden" name="dd3" value="' . $dd[3] . '">
						    <input type="hidden" name="dd4" value="' . $dd[4] . '">
						    <input type="hidden" name="dd5" value="' . $dd[5] . '">
						    <input type="hidden" name="dd6" value="' . $dd[6] . '">
						    <input type="hidden" name="dd90" value="' . $dd[90] . '">
						    <input type="hidden" name="dd91" value="' . $dd[91] . '">
						    <input type="hidden" name="acao" value="' . $acao . '">
						<TD>
							e-mail: 
							<input type="text" style="width: 280px;" size="30" name="dd50" value="' . $dd[50] . '">
							<input type="submit" class="bt" name="dd51" value="enviar por e-mail">
						<TD>
							</form>
						<TD align="right">
							<input type="button" value="imprimir" class="bt" onclick="window.print();">
						</table>';

		if (($this -> email_check($dd[50]) == 1) and (strlen($dd[51]) > 0)) {
			$email -> enviar_email($dd[50], $assunto, $texto);
			$sx .= '<table width="100%" class="noprint">
								<TR><TD><font color="blue">E-mail enviado com sucesso para ' . $dd[50] . '</font>
							   </table>
						';
		}
		return ($sx);
	}

	function enviar_email($to = '', $subject = '', $messagem = '', $to_name = '') {
		global $hd, $replay_email, $replay_name;
		$this -> to_email = $to;
		$this -> to_name = $to_name;
		$this -> subject = $subject;
		$this -> message = $messagem;
		$this -> replay_email = $replay_email;
		$this -> replay_email = $replay_name;

		$this -> method_autenticado();
		return (1);
	}

	function method_mail() {
		$to = $this -> to;
		$subject = $e3;
		$body = $e4;

		$headers = $this -> header();

		if (mail($to, $this -> subject, $body, $headers)) {
			return ('OK');
		} else {
			return ('ERRO');
		}
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

	/*
	 * Header e-mail
	 */
	function header() {
		$headers .= "To: " . $this -> format_email($this -> to_email, $this -> to_name) . " \n";
		$headers .= "From: " . $this -> format_email($this -> from_email, $this -> from_name) . " \n";
		$headers .= "Mime-Version: 1.0 \n";
		//	$headers .= "Priority: Normal \n";
		//	$headers .= "Reply-To: " .$email_adm. " \n";
		//	$headers .= "Return-Path: ".$email_adm." \n";
		$headers .= "Subject: " . $this -> subject . " \n";
		//	$headers .= "X-Assp-Envelope-From:".$email_adm." \n";
		$headers .= 'Content-Type: text/html; charset="iso-8859-1"' . " \n";

		$headers = '';
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "To: " . $this -> format_email($this -> to_email, $this -> to_name) . " \n";
		if (strlen($this -> replay_email) > 0) {
			$headers .= "Reply-To: " . $this -> format_email($this -> replay_email, $this -> replay_name) . " \n";
		} else {
			$headers .= "Reply-To: " . $this -> format_email($this -> from_email, $this -> from_name) . " \n";
		}

		$headers .= "Content-type: text/html; charset=iso-8859-1\n";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		return ($headers);
	}

	function method_autenticado() {
		/* ERRO */
		echo '<HR>FALHA GERAL - method obsoleto<HR>';
		exit;
	}

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
