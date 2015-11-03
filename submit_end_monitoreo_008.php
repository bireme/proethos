<?php
require("cab.php");
require("_class/_class_cep_submit.php");
require("_class/_class_team.php");
require($include.'sisdoc_data.php');

require($include.'sisdoc_email.php');

require('_class/_class_ic.php');
$ic = new ic;

$proj = new submit;
$proj->doc_autor_principal = $ss->user_codigo;

require("_class/_class_ged.php");
require("_class/_class_cep.php");
$cep = new cep;

/****/
if (strlen($dd[91]) > 0)
	{
		$_SESSION['proj_page'] = $dd[91];
		redirecina('submit.php?time'.date("dmYhis"));				
	}
	
	$pag_id = round($_SESSION['proj_id']);
	$pag_page = round($_SESSION['proj_page']);

//if ($pag_id == 0) { $pag_page = 1; }
//if ($pag_page == 0) { $pag_page = 1; }
$pag_id = $_SESSION['proj_id'];
$dd[0] = $pag_id;
$protocolo = strzero($dd[0],7);

echo '<H2>'.msg('submit_end_monitoreo_008').'</h2>';
//echo msg('protocolo').' '.$protocolo;
echo '<BR><BR>';


echo '<div style="text-align: justify; width: 80%">';
echo msg('submit_end_monitoreo_008_text');
echo '</div>';

echo '</div>';
echo $hd->foot();
?>



