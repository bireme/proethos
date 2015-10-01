<?php
// This file is part of the ProEthos Software. 
// 
// Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
// ProEthos under the terms of the ProEthos License as published by PAHO, which
// restricts commercial use of the Software. 
// 
// ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details. 
// 
// You should have received a copy of the ProEthos License along with the ProEthos
// Software. If not, see
// https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt


/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @copyright � Pan American Health Organization, 2013. All rights reserved.
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage sisdoc_char
*/
set_error_handler("sisdocERROS"); 

$debug = true;
ini_set('display_errors', 1);
ini_set('error_reporting', 7);
set_error_handler("sisdocERROS");

function sisdocERROS($errno, $errstr, $errfile, $errline, $errcontext)
  {
  global $secu,$base,$base_name,$user_log,$debug,$ttsql,$rlt,$sql_query;
  if ($errno != '8')
  		{
		$email = 'renefgj@gmail.com
		';
		$tee = '<table width="600" bordercolor="#ff0000" border="3" align="center">';
		$tee .= '<TR><TD bgcolor="#ff0000" align="center"><FONT class="lt2"><FONT COLOR=white><B>ERRO  -['.$base.']-'.$base_name.'-</B></TD></TR>';
		$tee .= '<TR><TD align="center"><B><TT>';
		$tee .= 'Erro N�mero #'.$errno;
		$tee .= '<TR><TD><TT>';
		$tee .= '<BR>Remote Address: '.$_SERVER['REMOTE_ADDR'];
		$tee .= '<BR>Metodo: '.$_SERVER['REQUEST_METHOD'];
		$tee .= '<BR>Nome da p�gina: '.$_SERVER['SCRIPT_NAME'];
		$tee .= '<BR>Dom�nio: '.$_SERVER['SERVER_NAME'];
		$tee .= '<BR>Data: '.date("d/m/Y H:i:s");
		
		if (strlen(trim($user_log)) > 0) { $tee .= '<TR><TD><TT>'; $tee .= 'User: '.$user_log; }
		if ($base == 'pgsql') { $tee .= '<TR><TD><B><TT>'; $tee .= pg_last_error(); }
		
		if (strlen(trim($sql_query)) > 0) { $tee .= '<TR><TD><TT>SQL:'.$sql_query; $tee .= $ttsql; }

		$tee .= '<TR><TD><TT>';
		$tee .= '<BR>File: '.$errstr;
		$tee .= '<BR>Line: '.$errline;
		$tee .= '<BR>File: '.$errfile;
		$tee .= '<TR><TD><TT>';
		$tee .= '<BR>Request URI:'.$_SERVER['REQUEST_URI'];
		$tee .= '<TR><TD><TT>';
		$args = $_SERVER['argv'];
		for ($rrr=0;$rrr < count($args);$rrr++)
			{ $tee .= 'args['.$rrr.'] == '.$args[$rrr].'<BR>'; }

		
		$tee .= '</table>';
		if ($debug == 1) { echo $tee; }
//		if ($debug == 3) { echo 'Muitas conex�es, aguarde....'; }
		
		$headers = '';	
		$headers .= 'To: Rene (Monitoramento) <rene@fonzaghi.com.br>' . "\r\n";
		$headers .= 'From: BancoSQL (PG) <rene@sisdoc.com.br>' . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		

		mail($email, 'Erros de Script'.$secu, $tee, $headers);
				
		die();
		}
  } 
?>