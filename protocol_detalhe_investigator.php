<?
 /**
  * Protocol
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Protocol
 */
$breadcrumbs = array();
array_push($breadcrumbs,array('main.php','principal'));
array_push($breadcrumbs,array('','project'));

require("cab.php");
require($include."_class_email_smtp.php");
require($include."sisdoc_data.php");
require($include."sisdoc_autor.php");
require('_class/_class_ic.php');
require('_class/_class_oms.php');
require('_class/_class_cep_email.php');
$comu = new comunication;
require("_class/_class_cep.php");
$cep = new cep;

require('_class/_class_cep_comment.php');

require('_ged_config.php');
$comme = new cep_comment;

/* Projetct Identifier */
if (strlen($dd[0]) > 0)
	{
	if (!(checkpost($dd[0]) == $dd[90]))
		{	
			echo 'erro de post';
			exit;
		}
		$_SESSION['proto_cep'] = $dd[0];
		redirecina(page());
	} else {
		$dd[0] = $_SESSION['proto_cep'];
		if (round($dd[0]) <= 0)
			{ redirecina('main.php'); }
	}
$cep->le($dd[0]);

$status = $cep->line['cep_status'];
//$pcor = $cep->cep_cores();
//$scor = $cep->status_cor($status);

/* Pareceres tempor�rios */

require('_class/_class_cep_parecer_avaliation.php');

$parav = new parecer_avaliation;
$parav->protocolo = $cep->protocolo;
$comu->protocolo = $cep->codigo;
$st = 'Detalhe do Protocolo';
$sh = '';
$sx = 'Projeto';
//require("protocolo_cab.php");
	{
	$protocolo = $cep->protocolo;
	$comme->codigo = $cep->codigo;
	
	echo '<div id="the_files">';
		echo '<table width="100%" border=0  class="lt1">';
		echo '<TR><TD>';
		echo $cep->dados();
		echo '</table>';
	echo '</div>';
	
	
	echo '<BR>';
	
	/* Research Management - Enmienda */
	$status = trim($cep->line['cep_status']);
	if (($status == 'P') or ($status == 'Z'))
	{
		echo $cep->show_amendment();
		echo $cep->form_send_amendment();
	}		
	
	/* Files List */
	echo '<div id="the_files">';
		echo '<table width="100%" border=0 align="center" class="lt1" align="center">';
		echo '<TR><TD>';
		echo '<fieldset><legend>'.msg('files').'</legend>';
		$ged->protocol = $cep->protocolo;
		echo $ged->filelist();
		
		echo '</fieldset>';
		echo '</table>';
	echo '</div>';
	echo '<BR>';

	echo '<fieldset><legend>'.msg('historic').'</legend>';
	echo '<div id="the_history">';
		echo '<div id="bha" style="text-align: left;">'.msg('show_historic').'</div>';
		echo '<div id="the_history_show" style="display:none;">';
		echo '<table width="100%" bgcolor="#F0F0F0">';
		echo '<TR valign="top"><TD>';		
		echo '<font class="lt3">'.msg('historic').'</font>';
		echo $cep->cep_historic();
		echo '<TD width="25"><img src="img/icone_close.png" id="bhe" width="25"  style="cursor: pointer;">';
		echo '</table>';
		echo '</div>';
	echo '</div>';	
	echo '</fieldset>';
	} 
echo '</div>'; 
echo '</div>'; 

echo $hd->foot();
?>
<script>
	$("#bha").click(function () 
		{ 
			$("#the_history_show").fadeIn("slow");
			$("#bha").fadeOut("slow");
		} );
	$("#bhe").click(function () 
		{ 
			$("#the_history_show").fadeOut("slow");
			$("#bha").fadeIn("slow");
		} );
	$("#bhc").click(function () 
		{ 
			$("#the_email_show").fadeIn("slow");
			$("#bhc").fadeOut("fast");
		} );
	$("#bhd").click(function () 
		{ 
			$("#the_email_show").fadeOut("slow");
			$("#bhc").fadeIn("slow");
		} );
	
</script>
