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
     * DB
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright � Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.14.17
	 * @package System
	 * @subpackage Database connection
    */
    
	/* Noshow Errors */
	$debug = 0; $debug1 = 0; $debug2 = 0;
	if (file_exists('debug.txt')) { $debug1 = 0; $debug2 = 255; } 	
	
	ini_set('display_errors', $debug1);
	ini_set('error_reporting', $debug2);
	    
    if (!isset($include)) { $include = '_include/'; }
	else { $include .= '_include/'; }
	
	/* Valida diretorios */	
	if (!is_dir($include)) {$include = '../'.$include; }
	if (!is_dir($include)) {$include = '../include/'; }
	if (!is_dir($include)) {$include = '../../include/'; }
	if (!is_dir($include)) {$include = '../../include/'; }

    ob_start();
	session_start();
	
	/* Path Directory */
	$path_info = trim($_SERVER['PATH_INFO']);
	
	/* Set header param */
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);	
	
    $ip = $_SERVER['SERVER_ADDR'];
	if ($ip == '::1') { $ip = '127.0.0.1'; }
	
	$charset = 'utf-8';
	header('Content-Type: text/html; charset='.$charset);
	
	/* Include */
	require($include.'_class_msg.php');
	require($include.'_class_char.php');		
	require($include.'sisdoc_sql.php');	
	
	
	/* Leituras das Variaveis dd0 a dd99 (POST/GET) */
	$vars = array_merge($_GET, $_POST);
	$acao = troca($vars['acao'],"'",'�');
	for ($k=0;$k < 100;$k++)
		{
		$varf='dd'.$k;
		$varf=$vars[$varf];
		$dd[$k] = post_security($varf);
		}	
	
	/* Data base */
	$filename = $include."../_db/db_mysql_".$ip.".php";
	if (file_exists($filename))
		{
			require($filename);

		} else {		
			if ($install != 1) 
				{
				redireciona('__install/index.php');
				
				if (!file_exists($file))
					{
						echo '<H1>Configura��o do sistema</h1>';
						require("db_config.php");
						exit;
					} else {
						echo 'Contacte o administrador, arquivo de configura��o inv�lido';
					}
				
		}	
	}	

function post_security($s)
	{
		$s = troca($s,'<','&lt;');
		$s = troca($s,'>','&gt;');
		$s = troca($s,'"','&quot;');
		//$s = troca($s,'/','&#x27;');
		$s = troca($s,"'",'&#x2F;');
		return($s);		
	}    
?>