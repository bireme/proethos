<?php
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