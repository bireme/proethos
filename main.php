<?php
	/*
	* PPP  RRR   OO  EEEE TTT H  H  OO   SSS
	* P  P R  R O  O EEE   T  H  H O  O S  
	* PPP  RRR  O  O EE    T  HHHH O  O  SS
	* P    R R  O  O E     T  H  H O  O    S
	* P    R  R  OO  EEEE  T  H  H  OO  SSS
	* 
	* Copyright (C) 2014 - Pan American Health Organization
	
	    This program is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.
	
	    This program is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
	    Proethos Copyright (C) 2014 - Pan American Health Organization
	 
	    This program comes with ABSOLUTELY NO WARRANTY; for details type `http://proethos.sisdoc.com.br/WARRANTY'.
	    This is free software, and you are welcome to redistribute it
	    under certain conditions; type `http://proethos.sisdoc.com.br/DISCLAIMER' for details.
	*/
	
  /**
  * Main page
  * @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
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
echo $rs->calender();

echo '</div>';	
	

require("foot.php");
?>
