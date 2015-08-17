<?php
require("db.php");
header ("Content-Type:text/xml");

require("_class/_class_cep.php");
$cep = new cep;

$id = round($dd[0]);
$dx = $dd[90];

if (checkpost($id) == $dx)
	{
		$cep->le($id);
		require("_class/_class_oms.php");
		$oms = new oms;
		echo $oms->xml($cep);
	} else {
		echo 'post error';
	}
?>
