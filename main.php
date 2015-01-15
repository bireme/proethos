<?php
  /**
  * Main page
  * @author Rene F. Gabriel Junior <renefgj@gmail.com>
  * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
  * @access public
  * @version v0.13.46
  * @package ProEthos
  * @subpackage Main
 */
/* mark active page to cabmenu */
$active_page = 'home';

require("cab.php");

/* Library */
require($include.'sisdoc_data.php');

/* Resume */
require("_class/_class_resume.php");
require($include.'sisdoc_data.php');
$rs = new resume;


/* load config committee */		
require("_class/_class_committee.php");
$cmt = new committee;
if ($cmt->config_exist_file()!=0)
	{ require_once($cmt->file); }
	
/* Valida paramentros do Committee */
require_once("_class/_class_committee.php");
$cmt = new committee;
if ($cmt->config_exist_file()==0) { redirecina('admin_committe.php'); }

/* Carrega dados do calendário */
require("_class/_class_calender.php");
$cal = new calendar;

/* Mostra resumo */
echo $rs->resume();
echo '<BR>';
/* Se form membro do CEP, mostra resumo */
if ($perfil->valid('#MEM')) 
	{
		echo $rs->resume_cep(); 
	} else {
		if ($perfil->valid('#ADC')){ echo $rs->resume_adhoc(); }
	}

/* Show Calender */
echo '<BR>';
echo '<fieldset>';
echo $rs->calender();
echo '</fieldset>';

echo '</div>';	
	

require("foot.php");
?>
