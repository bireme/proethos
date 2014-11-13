<?php
    /**
     * DB
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2014 - sisDOC.com.br
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
	$acao = troca($vars['acao'],"'",'´');
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
						echo '<H1>Configuração do sistema</h1>';
						require("db_config.php");
						exit;
					} else {
						echo 'Contacte o administrador, arquivo de configuração inválido';
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
	