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


require("../db.php");
ini_set('display_errors', 255);
ini_set('error_reporting', 255);

require($include.'_class_debug.php');

require("../_class_install.php");
$inst = new install;
$file_db = $inst->config_file();
//require("../customize_error.php");

/* Valida dados */
$err = 0;

if (strlen($dd[1]) == 0)
	{
		echo 'Database type not selected';
		exit;
	}

/* Valida Servidor */
if (strlen($dd[2]) == 0)
	{
		echo 'Database host not found';
		exit;
	}
 



/* Valida Database name */
if (strlen($dd[3]) == 0)
	{
		echo 'Database name not found';
		exit;
	}


/* Valida Database name */
if (strlen($dd[4]) == 0)
	{
		echo 'User name not found';
		exit;
	}

/* Data to connect */


echo 'Connecting...';

$base 	   = $dd[1];
$base_host = $dd[2];
$base_name = $dd[3];
$base_user = $dd[4];
$base_pass = $dd[5];
$ok = trim(db_connect());

if (strlen($ok) > 0)
	{
		echo 'ok';
		$file = '../../_db/db_proethos.php';
		$inst->createfile_db($file,$base,$base_host,$base_name,$base_user,$base_pass);
		echo '<BR><font class="successful">Config file was create</font>';
		echo '<BR>';
		echo '<A HREF="../">Return to Proethos</A>';			
		echo '<BR>';

		require($file);
		
		$inst->install_sql();

	
	}

?>