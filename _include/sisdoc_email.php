<?
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage E-mail
*/
///////////////////////////////////////////
// Vers�o atual           //    data     //
//---------------------------------------//
// 0.0c                       16/07/2008 //
// 0.0b                       07/07/2008 //
// 0.0a                       20/05/2008 //
///////////////////////////////////////////
if ($mostar_versao == True) {array_push($sis_versao, array("sisDOC (e-mail)", "0.0c", 20080716));
}
if (strlen($include) == 0) { exit ;
}
if (strlen($sisdoc_email) == 0) {
	$sisdoc_email = 1;
	/**
	 * rodape do envio de e-mail
	 */
	function emailfoot($texto, $email_to, $subject) {
		if (strlen($email_to) > 0) {
			global $cnn, $email_adm, $admin_nome;
			echo 'enviando ';
			echo $email_adm;
			echo ' e para ' . $email_to;
			echo '<BR>';
			echo $admin_nome;
			if (enviaremail($email_to, $e2, $subject, $texto)) {
				return (true);
			}
		}
		return (false);
	}

	function emailcab($http_local) {
		global $dd;
		$bb1 = "imprimir";
		$bb2 = "enviar por e-mail";
		$s = '<TABLE cellpadding="0" cellspacing="0" border="0" class="lt1" width="100%">';
		$s .= '<TR>';
		$s .= '<form method="post" action="' . $http_local . '" >';
		$s .= '<TD>&nbsp;e-mail:&nbsp;';
		$s .= '<input type="text" name="dd80" value="' . $dd[80] . '" size="30" maxlength="100">';
		$s .= '&nbsp;';
		$s .= '<input type="submit" name="dd81" value="' . $bb2 . '">';
		$s .= '<TD align="right">';
		$s .= '<input type="submit" name="dd81" value="' . $bb1 . '">';
		$s .= '</TD>';
		$s .= '<TD width="1"></form></TD>';
		$s .= '</TR>';
		$s .= '<TR><TD colspan="10"><HR size="1"></TD></TR>';
		$s .= '</TABLE>';
		if (strlen($dd[81]) > 0) {
			if ($dd[81] == $bb1) {
				$s = '<SCRIPT LANGUAGE="JavaScript">' . chr(13);
				$s .= '		window.print();  ' . chr(13);
				$s .= '</script>' . chr(13);
			}
			if (($dd[81] == $bb2) and (strlen($dd[80]) > 0)) {
				$s = '';
			}
		}
		return ($s);
	}

	if (!function_exists('enviaremail')) {
		function enviaremail($e1, $e2, $e3, $e4, $tipo = 'N') {
			if ($tipo == 'N') {
				enviaremail_normal($e1, $e2, $e3, $e4);
			} else {
				enviaremail_authe($e1, $e2, $e3, $e4);
			}
		}

	}

	function enviaremail_authe($destinatarios, $nada, $assunto, $mensagem, $tela = '') {
		global $email_adm, $admin_nome, $admin_name, $admin_email;

		if (strlen($admin_nome) == 0) { $admin_nome = $email_adm;
		}
		if (strlen($admin_nome) == 0) { $admin_nome = $admin_name;
		}

		if (strlen($email_adm) == 0) { $admin_nome = $admin_email;
		}

		$usuario = 'rene@fonzaghi.com.br';
		$senha = '448545ct';
		//$senha = 'falebr';
		$nomeDestinatario = '';
		$nomeRemetente = $admin_nome;
		//
		// $destinatarios = 'renefgj@gmail.com';
		$tela .= '(tela)';

		$resposta .= '(resposta)';

		/**********************************************************/
		$headers = '';
		$headers .= "To: " . $e1 . " \n";
		$headers .= "From: " . $admin_nome . " <" . $email_adm . "> \n";
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
		$headers .= "Reply-To: " . $email_adm . " \n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: " . $admin_nome . " <" . $email_adm . "> \r\n";
		/****************************************************************/

		$_POST['mensagem'] = nl2br($headers . $mensagem);

		/***********************************A PARTIR DAQUI NAO ALTERAR************************************/
		foreach ($_POST as $dados['me1'] => $dados['me2']) { $dados['me3'][] = '<b>' . $dados['me1'] . '</b>: ' . $dados['me2'];
		}

		//	$dados['me3'] = '<hr><h4>Mensagem do site</h4>'.implode('<br>', $dados['me3']).'<hr>';
		$dados['me3'] = $mensagem;
		$dados['email'] = array('usuario' => $usuario, 'senha' => $senha, 'servidor' => 'smtp.' . substr(strstr($usuario, '@'), 1), 'nomeRemetente' => $nomeRemetente, 'nomeDestinatario' => $nomeDestinatario, 'resposta' => $resposta, 'assunto' => $assunto, 'mensagem' => $dados['me3']);

		ini_set('php_flag mail_filter', 0);
		$conexao = fsockopen($dados['email']['servidor'], 587, $errno, $errstr, 10);
		fgets($conexao, 512);
		$dados['destinatarios'] = explode(',', $destinatarios);
		foreach ($dados['destinatarios'] as $dados['1']) {
			$dados['destinatarios']['RCPTTO'][] = '< ' . $dados['1'] . ' >';
			$dados['destinatarios']['TO'][] = $dados['1'];
		}
		$dados['cabecalho'] = array('EHLO ' => $dados['email']['servidor'], 'AUTH LOGIN', base64_encode($dados['email']['usuario']), base64_encode($dados['email']['senha']), 'MAIL FROM: ' => '< ' . $dados['email']['usuario'] . ' >', 'RCPT TO:' => $dados['destinatarios']['RCPTTO'], 'DATA', 'MIME-Version: ' => '1.0', 'Content-Type: text/html; charset=iso-8859-1', 'Date: ' => date('r', time()), 'From: ' => array($dados['email']['nomeRemetente'] . ' ' => '< ' . $dados['email']['usuario'] . ' >'), 'To:' => array($dados['email']['nomeDestinatario'] . ' ' => $dados['destinatarios']['TO']), 'Reply-To: ' => $dados['email']['resposta'], 'Subject: ' => $dados['email']['assunto'], 'mensagem' => $dados['email']['mensagem'], 'QUIT');
		foreach ($dados['cabecalho'] as $dados['2'] => $dados['3']) {
			if (is_array($dados['3'])) {
				foreach ($dados['3'] as $dados['4'] => $dados['5']) {
					$dados['4'] = empty($dados['4']) ? '' : $dados['4'];
					$dados['5'] = empty($dados['5']) ? '' : $dados['5'];
					$dados['4'] = is_numeric($dados['4']) ? '' : $dados['4'];
					if (is_array($dados['5'])) { $dados['5'] = "< " . implode(', ', $dados['5']) . " >";
					}
					fwrite($conexao, $dados['2'] . $dados['4'] . $dados['5'] . "\r\n", 512) . '<br>';
					fgets($conexao, 512);
				}
			} else {
				$dados['2'] = empty($dados['2']) ? '' : $dados['2'];
				$dados['3'] = empty($dados['3']) ? '' : $dados['3'];
				$dados['2'] = is_numeric($dados['2']) ? '' : $dados['2'];

				if ($dados['2'] == 'Subject: ') {
					fwrite($conexao, $dados['2'] . $dados['3'] . "\r\n", 512) . '<br>';
					fwrite($conexao, "\r\n", 512) . '<br>';
					fgets($conexao, 512);
				} elseif ($dados['2'] == 'mensagem') {
					fwrite($conexao, $dados['3'] . "\r\n.\r\n") . '<br>';
					fgets($conexao);
				} else {
					fwrite($conexao, $dados['2'] . $dados['3'] . "\r\n", 512) . '<br>';
					fgets($conexao, 512);
				}
			}
		}
		fclose($conexao);
		return (1);
	}

	function enviaremail_normal($e1, $e2, $e3, $e4) {
		global $email_adm, $admin_nome, $admin_name, $admin_email;

		if (strlen($admin_nome) == 0) { $admin_nome = $email_adm;
		}
		if (strlen($admin_nome) == 0) { $admin_nome = $admin_name;
		}

		if (strlen($email_adm) == 0) { $admin_nome = $admin_email;
		}

		$to = $e1;
		$subject = $e3;
		$body = $e4;
		$headers = '';
		$headers .= "To: " . $e1 . " \n";
		$headers .= "From: " . $admin_nome . " <" . $email_adm . "> \n";
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
		$headers .= "Reply-To: " . $email_adm . " \n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: " . $admin_nome . " <" . $email_adm . "> \r\n";

		//	$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">'."\n".$body;
		if (mail($to, $subject, $body, $headers)) {
			return ('OK');
		} else {
			return ('ERRO');
		}
	}

	if (!function_exists('enviaremail')) {
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

	}

}
?>
