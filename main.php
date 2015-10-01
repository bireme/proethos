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
  * Main page
  * @author Rene F. Gabriel Junior <renefgj@gmail.com>
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
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