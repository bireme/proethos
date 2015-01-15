<?
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage E-mail
*/

/**
* rodapé do envio de e-mail
*/

class email
	{
		var $id_email;
		var $destino;
		var $assunto;
		var $texto;
		var $status;
		
		function salva()
			{
				$email = $this->destino;
				$assunto = $this->assunto;
				$texto = $this->texto;
				$ip = $_SERVER['REMOTE_ADDR'];
				$data = date("Ymd");
				$hora = date("H:i:s");
				$sql = "insert into _email 
				(ma_email, ma_assunto, ma_texto, ma_data,
				ma_hora, ma_status, ma_ip,
				ma_conta, ma_enviado, ma_enviado_hora)
				values ('$email','$assunto','$texto', '$data',
				'$hora','@','$ip',
				'',19000101,'');";
				$rlt = db_query($sql);
				return(1);
			}
			
		/**
		 *  Resumo to total de email para enviar
		 */
		function resumo_email_enviar()
			{
				$sql = "select count(*) as total, ma_status 
						from _email 
						where ma_status = '@' 
						group by ma_status ";
				$rlt = db_query($sql);
				$line = db_read($rlt);
				$rsp = $line['total'];
				return($rsp);
			}
			
		/**
		 * Le o registro atual
		 */
		function le($id='')
			{
				if (strlen($id) > 0) { $this->id_mail = $id; }
				$sql = "select * from _email where id_ma = ".round($this->id_mail);
				$rlt = db_query($sql);
				$line = db_read($rlt);
				$this->id_email = $line['id_ma'];
				$this->destino = $line['ma_email'];
				$this->assunto = $line['ma_assunto'];
				$this->texto = $line['ma_texto'];
				$this->status = $line['ma_status'];
				return(1);
			}
			
		/**
		 * Envia próximo e-mail da lista
		 */			
		function enviar_proximo()
			{
				$sql = "select min(id_ma) as id_ma from _email 
						where ma_status = '@' ";
				$rlt = db_query($sql);
				$line = db_read($rlt);
				$this->le($line['id_ma']);
				
				$e1 = $this->destino;
				$e3 = $this->assunto;
				$e4 = $this->texto;
				$sql = "update _email set ma_status = 'A' where id_ma = ".$this->id_mail;
				$rlt = db_query($sql);
				enviaremail2($e1,'',$e3,$e4);
				$sql = "update _email set ma_status = 'B' where id_ma = ".$this->id_mail;
				$rlt = db_query($sql);
				echo '<BR>Enviado para '.$this->destino;
				exit;						
			}
		function resumo()
			{
				$sql = "select count(*) as total, ma_status 
						from _email 
						group by ma_status
						order by ma_status ";
				$rlt = db_query($sql);
				$rsp = array();
				while ($line = db_read($rlt)) { array_push($rsp,$line); }
				return($rsp);
			}
			
		function structure()
			{
			$sql = "CREATE TABLE _email (
				id_ma SERIAL NOT NULL ,
				ma_email CHAR( 80 ) NOT NULL ,
				ma_assunto CHAR( 100 ) NOT NULL ,
				ma_texto text,
				ma_data INT NOT NULL ,
				ma_hora CHAR( 8 ) NOT NULL ,
				ma_status CHAR( 1 ) NOT NULL ,
				ma_ip CHAR( 15 ) NOT NULL ,
				ma_conta CHAR( 3 ) NOT NULL ,
				ma_enviado INT NOT NULL ,
				ma_enviado_hora CHAR( 8 ) NOT NULL
				);";
				//$sql .= "ALTER TABLE _email ADD INDEX key_email_status ( ma_status ( 1 ) ) ";	
			return($sql);
			}
	}

function enviaremail($e1,$e2,$e3,$e4)
	{
		$em = new email;
		/* Criar e-mail da estrutura */
		//$sql = $em->structure();
		//$rlt = db_query($sql);
		
		$em->destino = $e1;
		$em->assunto = $e3;
		$em->texto = $e4;
		$em->salva();
		return(1);
	}
function enviaremail2($e1,$e2,$e3,$e4)
	{
	global $email_adm, $admin_nome;
	if (strlen($admin_nome) == 0) { $admin_nome = $email_adm; }
	$to = $e1;
	$subject = $e3;
	$body = $e4;
	$headers = '';
	$headers .= "To: ".$e1." \n";
	$headers .= "From: ".$admin_nome." <" .$email_adm. "> \n";
	$headers .= "Mime-Version: 1.0 \n";
//	$headers .= "Priority: Normal \n";
//	$headers .= "Reply-To: " .$email_adm. " \n";
//	$headers .= "Return-Path: ".$email_adm." \n";
//	$headers .= "Subject: ".$subject." \n";
//	$headers .= "X-Assp-Envelope-From:".$email_adm." \n";
	$headers .= 'Content-Type: text/html; charset="iso-8859-1"'." \n";		
	
	$headers = '';
	$headers .= "MIME-Version: 1.0\n" ;
	$headers .= "To: ".$e1." \n";
	$headers .= "Reply-To: " .$email_adm. " \n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";	
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
	$headers .= "From: ".$admin_nome." <" .$email_adm. "> \r\n";

//	$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">'."\n".$body;
	
	if (e_mail($to, $subject, $body, $headers)) 
		{ return('OK'); } else { return('#ERRO#'); }
 }
 /** TESTE */
 
 function e_mail($destinatarios,$assunto,$mensagem,$tela)
 {
// $usuario = 'revivendo@revivendom.dominiotemporario.com';
 $usuario = 'cryogene@cryogene.dominiotemporario.com';
 $senha = '102030fo40';
 //$senha = 'falebr';
 $nomeDestinatario = '';
 $nomeRemetente = "Revivendo Musicas";
 $nomeRemetente = "Cryogene";
//
// $destinatarios = 'renefgj@gmail.com';
 $tela .= '(tela)';

 $resposta .= '(resposta)';
 
 $_POST['mensagem'] = nl2br($mensagem);
 
 /***********************************A PARTIR DAQUI NAO ALTERAR************************************/
	foreach ($_POST as $dados['me1'] => $dados['me2'])
	{ $dados['me3'][] = '<b>'.$dados['me1'].'</b>: '.$dados['me2']; }

//	$dados['me3'] = '<hr><h4>Mensagem do site</h4>'.implode('<br>', $dados['me3']).'<hr>';
	$dados['me3'] = $mensagem;
	$dados['email'] = array('usuario' => $usuario, 'senha' => $senha, 'servidor' => 'smtp.'.substr(strstr($usuario, '@'), 1), 'nomeRemetente' => $nomeRemetente, 'nomeDestinatario' => $nomeDestinatario, 'resposta' => $resposta, 'assunto' => $assunto, 'mensagem' => $dados['me3']);
	
	ini_set('php_flag mail_filter', 0);
	$conexao = fsockopen($dados['email']['servidor'], 587, $errno, $errstr, 10);
	fgets($conexao, 512);
	$dados['destinatarios'] = explode(',', $destinatarios);
	foreach ($dados['destinatarios'] as $dados['1'])
	{
		$dados['destinatarios']['RCPTTO'][] = '< '.$dados['1'].' >';
		$dados['destinatarios']['TO'][] = $dados['1'];
	}
	$dados['cabecalho'] = array('EHLO ' => $dados['email']['servidor'], 'AUTH LOGIN', base64_encode($dados['email']['usuario']), base64_encode($dados['email']['senha']), 'MAIL FROM: ' => '< '.$dados['email']['usuario'].' >', 'RCPT TO:' => $dados['destinatarios']['RCPTTO'], 'DATA', 'MIME-Version: ' => '1.0', 'Content-Type: text/html; charset=iso-8859-1', 'Date: ' => date('r',time()), 'From: ' => array($dados['email']['nomeRemetente'].' ' => '< '.$dados['email']['usuario'].' >'), 'To:' => array($dados['email']['nomeDestinatario'].' ' => $dados['destinatarios']['TO']), 'Reply-To: ' => $dados['email']['resposta'],'Subject: ' => $dados['email']['assunto'], 'mensagem' => $dados['email']['mensagem'], 'QUIT');
	foreach ($dados['cabecalho'] as $dados['2'] => $dados['3'])
	{
		if (is_array($dados['3']))
		{ foreach ($dados['3'] as $dados['4'] => $dados['5']) {
			$dados['4'] = empty($dados['4']) ? '' : $dados['4'];
			$dados['5'] = empty($dados['5']) ? '' : $dados['5'];
			$dados['4'] = is_numeric($dados['4']) ? '' : $dados['4'];
			if (is_array($dados['5']))
				{ $dados['5'] = "< ".implode(', ', $dados['5'])." >"; }
			fwrite($conexao, $dados['2'].$dados['4'].$dados['5']."\r\n", 512).'<br>';
			fgets($conexao, 512);
		}
	} else {
	$dados['2'] = empty($dados['2']) ? '' : $dados['2'];
	$dados['3'] = empty($dados['3']) ? '' : $dados['3'];
	$dados['2'] = is_numeric($dados['2']) ? '' : $dados['2'];
	
	if ($dados['2'] == 'Subject: ')
	{
		fwrite($conexao, $dados['2'].$dados['3']."\r\n", 512).'<br>';
		fwrite($conexao, "\r\n", 512).'<br>';
		fgets($conexao, 512);
	} elseif ($dados['2'] == 'mensagem') 
		{
			fwrite($conexao, $dados['3']."\r\n.\r\n").'<br>';
			fgets($conexao);
		} else {
			fwrite($conexao, $dados['2'].$dados['3']."\r\n", 512).'<br>';
			fgets($conexao, 512);
		}
	}
}
fclose($conexao);
return(1);
}
 ?>
