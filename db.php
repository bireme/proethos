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

ob_start();
session_start();

//$path_info = trim($_SERVER['PATH_INFO']);
date_default_timezone_set('GMT');

ini_set('display_errors', 1);
ini_set('error_reporting', 7);

//$include .= '../../include/';
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

$http_server = $_SERVER["SERVER_NAME"];

/* Find Include Directory */
$path = array('_include/','../_include/','../../_include/');
for ($r=0;$r < count($path);$r++)
	{
		if (is_dir($path[$r]))
			{
				$include = $path[$r];
				$r = 99;
			}
	}
//-------------------------------------- Paramentros para DEBUG

global $user_id,$user_nome,$dd,$user_nivel;

require($include."sisdoc_char.php");
require($include.'sisdoc_sql.php');

//-------------------------------------- Diret�rios de Arquivos e Imagens
$dir = $_SERVER['DOCUMENT_ROOT'];
$uploaddir = $dir.'/nep/';
//-------------------------------------- Leituras das Variaveis dd0 a dd99 (POST/GET)
$vars = array_merge($_GET, $_POST);
for ($k=0;$k < 100;$k++)
	{
	$varf='dd'.$k;
	$varf=$vars[$varf];
	//if (isset($varf) and ($k > 1)) {	//$varf = str_replace($varf,"A","�"); }
	$dd[$k] = xss_security_post($varf);
	}
$acao = $vars['acao'];
$nocab = $vars['nocab'];
//-------------------------------------- Determina o Idioma de Navega��o
$idv = $vars['idioma'];
//-------------------------------------------- Biblioteca
$tab_max = '100%';

$db_config = '_db/db_proethos.php';
if ($install != 1) 
	{
		/* Aquivo de configuração do banco de dados */
		if (!(file_exists($db_config)))
			{ redirecina('_install/'); }
		require($db_config);
	}

$edit_mode = round($_SESSION['editmode']);

function show_logo()
	{
		global $http;
		$sx .= '<img src="img/logo_proethos.png" height=18>&nbsp;';
		$sx .= msg('about_print');
		return($sx);
	}

function xss_security_post($s)
	{
		$s = troca($s,'<','&lt;');
		$s = troca($s,'>','&gt;');
		$s = troca($s,'"','&quot;');
		//$s = troca($s,'/','&#x27;');
		$s = troca($s,"'",'&#x2F;');
		return($s);		
	}	
?>