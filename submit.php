<?php
/* Header */
/* mark active page to cabmenu */
$active_page = 'research';
require("cab.php");

/* Load Class */
require("_class/_class_cep_submit.php");

/* Load Includes */
require($include.'sisdoc_data.php');
require($include.'_class_form.php');
$form = new form;

$proj = new submit;
$proj->doc_autor_principal = $ss->user_codigo;

/****/
if (strlen($dd[91]) > 0)
	{
		$_SESSION['proj_page'] = $dd[91];
		redirecina('submit.php?time'.date("dmYhis"));				
	}
	
if (strlen($dd[90]) > 0)
	{
		$pag_id = 1; 
		$_SESSION['proj_id'] = $dd[0];
		$_SESSION['proj_page'] = 1;
		redirecina('submit.php?time'.date("dmYhis"));		
	} else {
		$pag_id = round($_SESSION['proj_id']);
		$pag_page = round($_SESSION['proj_page']);
	}
//if ($pag_id == 0) { $pag_page = 1; }
//if ($pag_page == 0) { $pag_page = 1; }
$pag_id = $_SESSION['proj_id'];
$pag = $_SESSION['proj_page'];

$dd[0] = $pag_id;
$protocolo = strzero($dd[0],7);

/* Budget */
require("_class/_class_budget.php");
$bud = new budget;
$bud->protocol = $protocolo;

/* Country */
require("_class/_class_ajax_pais.php");
$country = new country;
$country->protocol = $protocolo;

/* Documents */
require("_ged_config.php");
$ged->protocol = $protocolo;
$popup=1;
$proj->le($protocolo);

	{
		require("submit_cab.php");
		
		
		echo '<form method="post" action="'.page().'">';
		echo '<Table width="'.$tab_max.'" cellpadding=0 cellspacing=0 class="lt1" align="center" >';
		$pag_max = 6;
		if ($proj->doc_tipo == 'AMEND')
			{
				$pag_max = 3;
				if ($pag_page == 1) { require("submit_11.php"); }
				if ($pag_page == 2) { require("submit_12.php"); }
				if ($pag_page == 3) { require("submit_13.php"); }
			} else {
				if ($pag_page == 1) { require("submit_01.php"); }
				if ($pag_page == 2) { require("submit_02.php"); }
				if ($pag_page == 3) { require("submit_03.php"); }
				if ($pag_page == 4) { require("submit_04.php"); }
				if ($pag_page == 5) { require("submit_05.php"); }
				if ($pag_page == 6) { require("submit_06.php"); }
			}
		echo '</table>';
		echo '</form>';
	}
echo '</div>';
?>

<script>
	
</script>
<?
echo $hd->foot();	
?>



